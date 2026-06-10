<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'customer_name', 'customer_phone', 'customer_email',
        'address_street', 'address_kelurahan', 'address_kecamatan',
        'address_city', 'address_province', 'address_postal',
        'shipping_method', 'shipping_cost', 'payment_method',
        'payment_status', 'order_status', 'notes',
        'subtotal', 'total_amount', 'tracking_number',
        'midtrans_snap_token', 'midtrans_transaction_id',
    ];

    protected $casts = [
        'shipping_cost' => 'integer',
        'subtotal'      => 'integer',
        'total_amount'  => 'integer',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    public function getFormattedShippingCostAttribute(): string
    {
        return 'Rp ' . number_format($this->shipping_cost, 0, ',', '.');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->order_status) {
            'new' => 'Menunggu Konfirmasi',
            'processing' => 'Diproses',
            'packing' => 'Sedang Dikemas',
            'shipped' => 'Sedang Dikirim',
            'delivered' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => $this->order_status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->order_status) {
            'new' => 'blue',
            'processing' => 'indigo',
            'packing' => 'yellow',
            'shipped' => 'purple',
            'delivered' => 'green',
            'cancelled' => 'red',
            default => 'gray',
        };
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match ($this->payment_status) {
            'pending' => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'failed' => 'Gagal',
            default => $this->payment_status,
        };
    }

    public static function generateOrderNumber(): string
    {
        $date = now()->format('Ymd');
        $last = static::whereDate('created_at', today())
            ->orderByDesc('id')->first();
        $seq = $last ? ((int) substr($last->order_number, -4)) + 1 : 1;
        return 'BHI-' . $date . '-' . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }
}
