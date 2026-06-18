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

            $this->midtrans->handleNotification($payload);

            $transactionStatus = $payload['transaction_status'] ?? '';
            $fraudStatus       = $payload['fraud_status'] ?? '';
            $orderNumber       = preg_replace('/-\d+$/', '', $payload['order_id'] ?? '');
            $transactionId     = $payload['transaction_id'] ?? '';

            $order = Order::where('order_number', $orderNumber)->first();

            if (! $order) {
                return response()->json(['status' => 'order_not_found'], 404);
            }

            if ($order->payment_status === 'confirmed') {
                return response()->json(['status' => 'already_confirmed']);
            }

            $paymentStatus = $this->midtrans->resolvePaymentStatus($transactionStatus, $fraudStatus);

            $updateData = [
                'payment_status'          => $paymentStatus,
                'midtrans_transaction_id' => $transactionId,
            ];

            if ($paymentStatus === 'confirmed' && $order->order_status === 'new') {
                $updateData['order_status'] = 'processing';
            }

            $order->update($updateData);

            Log::info('Midtrans Confirm (onSuccess)', [
                'order_number' => $orderNumber,
                'status'       => $paymentStatus,
            ]);

            return response()->json(['status' => 'ok', 'payment_status' => $paymentStatus]);
        } catch (\Exception $e) {
            Log::error('Midtrans Confirm Error', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 403);
        }
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
