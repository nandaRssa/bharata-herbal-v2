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
     * Daftar semua metode pembayaran Midtrans yang tersedia beserta label dan icon-nya.
     */
    public static function availablePaymentMethods(): array
    {
        return [
            'bank_transfer' => ['label' => 'Bank Transfer (Virtual Account)', 'icon' => '🏦', 'via_midtrans' => true, 'group' => 'm_banking', 'midtrans_channel' => 'bank_transfer'],
            'qris'          => ['label' => 'QRIS',                          'icon' => '📷', 'via_midtrans' => true, 'group' => 'e_wallet', 'midtrans_channel' => 'qris'],
            'gopay'         => ['label' => 'GoPay',                         'icon' => '💚', 'via_midtrans' => true, 'group' => 'e_wallet', 'midtrans_channel' => 'gopay'],
            'dana'          => ['label' => 'DANA',                          'icon' => '💙', 'via_midtrans' => true, 'group' => 'e_wallet', 'midtrans_channel' => 'dana'],
            'ovo'           => ['label' => 'OVO',                           'icon' => '💜', 'via_midtrans' => true, 'group' => 'e_wallet', 'midtrans_channel' => 'ovo'],
            'brimo'         => ['label' => 'BRImo',                         'icon' => '🔵', 'via_midtrans' => true, 'group' => 'm_banking', 'midtrans_channel' => 'bri_epay'],
            'cod'           => ['label' => 'COD (Bayar di Tempat)',         'icon' => '🚪', 'via_midtrans' => false, 'group' => 'cod', 'midtrans_channel' => null],
        ];
    }

    /**
     * Default nilai payment_methods ketika belum diset.
     * Semua diaktifkan secara default.
     */
    public static function defaultPaymentMethods(): array
    {
        return [
            'bank_transfer' => true,
            'qris'          => true,
            'gopay'         => true,
            'dana'          => true,
            'ovo'           => true,
            'brimo'         => true,
            'cod'           => true,
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

        return array_filter($merged); // hanya yang bernilai true
    }

    public static function getInstance(): static
    {
        return static::firstOrCreate([], ['store_name' => 'Bharata Herbal ID']);
    }
}

