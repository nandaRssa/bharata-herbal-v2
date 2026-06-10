<?php

namespace App\Services;

use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$clientKey    = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
    }

    /**
     * Buat Snap Token untuk order tertentu.
     * Jika paymentMethod diberikan, Snap hanya akan menampilkan channel tersebut.
     */
    public function createSnapToken(Order $order, ?string $paymentMethod = null): string
    {
        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_number . '-' . time(), // unik per attempt
                'gross_amount' => (int) $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => $order->customer_name,
                'phone'      => $order->customer_phone,
                'email'      => $order->customer_email ?? 'customer@bharataherbal.id',
            ],
            'item_details' => $this->buildItemDetails($order),
        ];

        // Expiry 24 jam — Midtrans akan auto-cancel setelah waktu habis
        $params['expiry'] = [
            'start_time' => date('Y-m-d H:i:s O'),
            'unit'       => 'day',
            'duration'   => 1,
        ];

        // Batasi Snap ke channel yang dipilih customer
        // Khusus QRIS: fallback ke semua channel karena mungkin belum enable di akun
        if ($paymentMethod && $paymentMethod !== 'qris') {
            $channel = $this->resolveMidtransChannel($paymentMethod);
            if ($channel) {
                $params['enabled_payments'] = [$channel];
            }
        }

        return Snap::getSnapToken($params);
    }

    /**
     * Build item details dari order untuk Midtrans.
     */
    private function buildItemDetails(Order $order): array
    {
        $items = [];

        foreach ($order->items as $item) {
            $items[] = [
                'id'       => (string) $item->product_id,
                'price'    => (int) $item->price,
                'quantity' => (int) $item->quantity,
                'name'     => substr($item->product_name, 0, 50), // Midtrans max 50 chars
            ];
        }

        // Tambah ongkos kirim jika ada
        if ($order->shipping_cost > 0) {
            $items[] = [
                'id'       => 'shipping',
                'price'    => (int) $order->shipping_cost,
                'quantity' => 1,
                'name'     => 'Ongkos Kirim (' . $order->shipping_method . ')',
            ];
        }

        return $items;
    }

    /**
     * Mapping payment method internal ke channel Midtrans Snap.
     */
    private function resolveMidtransChannel(string $paymentMethod): ?string
    {
        return match ($paymentMethod) {
            'bank_transfer' => 'bank_transfer',
            'qris'          => 'qris',
            'gopay'         => 'gopay',
            'dana'          => 'dana',
            'ovo'           => 'ovo',
            'brimo'         => 'bri_epay',
            default         => null,
        };
    }

    /**
     * Verifikasi dan parse notifikasi dari Midtrans webhook.
     * Mengembalikan array notification data atau throw exception jika tidak valid.
     */
    public function handleNotification(array $payload): array
    {
        // Verifikasi signature
        $orderId           = $payload['order_id'] ?? '';
        $statusCode        = $payload['status_code'] ?? '';
        $grossAmount       = $payload['gross_amount'] ?? '';
        $signatureKey      = $payload['signature_key'] ?? '';

        $expectedSignature = hash('sha512',
            $orderId . $statusCode . $grossAmount . config('midtrans.server_key')
        );

        if ($signatureKey !== $expectedSignature) {
            throw new \Exception('Invalid Midtrans signature key.');
        }

        return $payload;
    }

    /**
     * Mapping transaction_status Midtrans ke payment_status internal.
     */
    public function resolvePaymentStatus(string $transactionStatus, string $fraudStatus = ''): string
    {
        return match (true) {
            in_array($transactionStatus, ['capture', 'settlement']) && $fraudStatus !== 'deny'
                => 'confirmed',
            in_array($transactionStatus, ['deny', 'cancel', 'expire', 'failure'])
                => 'failed',
            default
                => 'pending',
        };
    }
}
