<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'store_name', 'wa_number',
        'qris_image', 'store_address', 'operating_hours',
        'payment_methods',
    ];

    protected $casts = [
        'payment_methods' => 'array',
    ];

    const UPDATED_AT = 'updated_at';
    const CREATED_AT = null;

    /**
     * Daftar semua metode pembayaran Midtrans yang tersedia beserta nama icon lokalnya.
     */
    public static function availablePaymentMethods(): array
    {
        return [
            'bank_transfer' => ['label' => 'Bank Transfer (Virtual Account)', 'icon' => 'building', 'via_midtrans' => true, 'group' => 'm_banking', 'midtrans_channel' => 'bank_transfer'],
            'qris'          => ['label' => 'QRIS',                          'icon' => 'image', 'via_midtrans' => true, 'group' => 'e_wallet', 'midtrans_channel' => 'qris'],
            'gopay'         => ['label' => 'GoPay',                         'icon' => 'wallet', 'via_midtrans' => true, 'group' => 'e_wallet', 'midtrans_channel' => 'gopay'],
            'dana'          => ['label' => 'DANA',                          'icon' => 'wallet', 'via_midtrans' => true, 'group' => 'e_wallet', 'midtrans_channel' => 'dana'],
            'ovo'           => ['label' => 'OVO',                           'icon' => 'wallet', 'via_midtrans' => true, 'group' => 'e_wallet', 'midtrans_channel' => 'ovo'],
            'brimo'         => ['label' => 'BRImo',                         'icon' => 'building', 'via_midtrans' => true, 'group' => 'm_banking', 'midtrans_channel' => 'bri_epay'],
            'cod'           => ['label' => 'COD (Bayar di Tempat)',         'icon' => 'cash', 'via_midtrans' => false, 'group' => 'cod', 'midtrans_channel' => null],
        ];
    }

    /**
     * Default nilai payment_methods ketika belum diset.
     * Hanya Virtual Account (bank_transfer) yang aktif secara default.
     */
    public static function defaultPaymentMethods(): array
    {
        return [
            'bank_transfer' => true,
            'qris'          => false,
            'gopay'         => false,
            'dana'          => false,
            'ovo'           => false,
            'brimo'         => false,
            'cod'           => false,
        ];
    }

    /**
     * Ambil metode pembayaran yang sedang aktif (enabled).
     * Merge dengan default untuk memastikan semua key tersedia.
     */
    public function enabledPaymentMethods(): array
    {
        $saved    = $this->payment_methods ?? [];
        $defaults = static::defaultPaymentMethods();
        $merged   = array_merge($defaults, $saved);

        return array_filter($merged);
    }

    public static function getInstance(): static
    {
        return static::firstOrCreate([], ['store_name' => 'Bharata Herbal ID']);
    }
}
