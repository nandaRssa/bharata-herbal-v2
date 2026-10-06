<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct(private MidtransService $midtrans) {}

    /**
     * Kembalikan Snap token untuk order tertentu.
     * Dipanggil via AJAX dari halaman sukses ketika customer mau bayar.
     * GET /pesanan/{order}/snap-token
     */
    public function getSnapToken(Order $order)
    {
        try {
            // Kalau sudah punya token dan belum expired, gunakan yang lama
            if ($order->midtrans_snap_token) {
                return response()->json(['token' => $order->midtrans_snap_token]);
            }

            $token = $this->midtrans->createSnapToken($order, $order->payment_method);
            $order->update(['midtrans_snap_token' => $token]);

            return response()->json(['token' => $token]);
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error', [
                'order_number' => $order->order_number,
                'error'        => $e->getMessage(),
            ]);
            return response()->json(['error' => 'Gagal membuat token pembayaran: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Konfirmasi pembayaran dari Snap callback (onSuccess).
     * POST /payment/confirm
     * Dipanggil dari JS frontend ketika Snap.onSuccess() fires.
     * Diverifikasi signature seperti webhook biasa.
     */
    public function confirm(Request $request)
    {
        try {
            $payload = $request->all();

            $midtransOrderId = $payload['order_id'] ?? '';
            $transactionId   = $payload['transaction_id'] ?? '';
            $orderNumber     = preg_replace('/-\d+$/', '', $midtransOrderId);

            // Jika ada signature_key (panggilan dari webhook), verifikasi signature
            if (!empty($payload['signature_key'])) {
                $this->midtrans->handleNotification($payload);
            }

            $order = Order::where('order_number', $orderNumber)->first();

            if (! $order) {
                return response()->json(['status' => 'order_not_found'], 404);
            }

            if ($order->payment_status === 'confirmed') {
                return response()->json(['status' => 'already_confirmed']);
            }

            $transactionStatus = $payload['transaction_status'] ?? '';
            $fraudStatus       = $payload['fraud_status'] ?? '';

            // Verifikasi status ke Midtrans API langsung jika ada transaction_id atau order_id
            $idToCheck = $transactionId ?: $midtransOrderId;
            if ($idToCheck) {
                try {
                    $statusObj = \Midtrans\Transaction::status($idToCheck);
                    if ($statusObj) {
                        $transactionStatus = $statusObj->transaction_status ?? $transactionStatus;
                        $fraudStatus       = $statusObj->fraud_status ?? $fraudStatus;
                        $transactionId     = $statusObj->transaction_id ?? $transactionId;
                    }
                } catch (\Exception $ex) {
                    Log::warning('Midtrans Transaction::status check fallback to payload', [
                        'order_number' => $orderNumber,
                        'error'        => $ex->getMessage(),
                    ]);
                }
            }

            $paymentStatus = $this->midtrans->resolvePaymentStatus($transactionStatus, $fraudStatus);

            // Jika status transaksi settlement/capture, pastikan payment_status confirmed
            if (in_array($transactionStatus, ['settlement', 'capture'])) {
                $paymentStatus = 'confirmed';
            }

            $updateData = [
                'payment_status'          => $paymentStatus,
                'midtrans_transaction_id' => $transactionId ?: $order->midtrans_transaction_id,
            ];

            if ($paymentStatus === 'confirmed' && $order->order_status === 'new') {
                $updateData['order_status'] = 'processing';
            }

            $order->update($updateData);

            Log::info('Midtrans Confirm (onSuccess)', [
                'order_number'   => $orderNumber,
                'payment_status' => $paymentStatus,
                'order_status'   => $updateData['order_status'] ?? $order->order_status,
            ]);

            return response()->json(['status' => 'ok', 'payment_status' => $paymentStatus]);
        } catch (\Exception $e) {
            Log::error('Midtrans Confirm Error', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Simulasi sukses pembayaran (hanya di sandbox).
     * POST /pesanan/{order}/simulate-success
     */
    public function simulateSuccess(Order $order)
    {
        if (config('midtrans.is_production')) {
            abort(404);
        }

        if ($order->payment_status === 'confirmed') {
            return redirect()->back()->with('success', 'Pembayaran sudah dikonfirmasi.');
        }

        $order->update([
            'payment_status'          => 'confirmed',
            'midtrans_transaction_id' => 'SIM-' . strtoupper(uniqid()),
            'order_status'            => 'processing',
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil. Pesanan sedang diproses.');
    }

    /**
     * Handle webhook notifikasi dari Midtrans.
     * POST /payment/notification
     * Dikecualikan dari CSRF.
     */
    public function notification(Request $request)
    {
        try {
            $payload = $request->all();

            // Verifikasi signature
            $this->midtrans->handleNotification($payload);

            $transactionStatus = $payload['transaction_status'] ?? '';
            $fraudStatus       = $payload['fraud_status'] ?? '';
            $midtransOrderId   = $payload['order_id'] ?? '';
            $transactionId     = $payload['transaction_id'] ?? '';

            // Order ID di Midtrans format: "BHI-20260610-0001-{timestamp}"
            // Ambil bagian nomor pesanan asli sebelum tanda "-{timestamp}" di belakang
            $orderNumber = preg_replace('/-\d+$/', '', $midtransOrderId);

            $order = Order::where('order_number', $orderNumber)->first();

            if (! $order) {
                Log::warning('Midtrans: Order tidak ditemukan', ['order_id' => $midtransOrderId]);
                return response()->json(['status' => 'order_not_found'], 404);
            }

            $paymentStatus = $this->midtrans->resolvePaymentStatus($transactionStatus, $fraudStatus);

            $updateData = [
                'payment_status'           => $paymentStatus,
                'midtrans_transaction_id'  => $transactionId,
            ];

            // Jika pembayaran berhasil, update order_status ke processing
            if ($paymentStatus === 'confirmed' && $order->order_status === 'new') {
                $updateData['order_status'] = 'processing';
            }

            // Jika pembayaran gagal/expired dan order masih baru, batalkan otomatis
            if ($paymentStatus === 'failed' && $order->order_status === 'new') {
                $updateData['order_status'] = 'cancelled';
            }

            $order->update($updateData);

            Log::info('Midtrans Notification', [
                'order_number'      => $orderNumber,
                'transaction_status'=> $transactionStatus,
                'payment_status'    => $paymentStatus,
            ]);

            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }
}
