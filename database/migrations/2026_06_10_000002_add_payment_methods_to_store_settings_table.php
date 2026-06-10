<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('store_settings', function (Blueprint $table) {
            // JSON column untuk menyimpan status aktif/nonaktif metode pembayaran Midtrans
            // Kolom bank/e-wallet lama TIDAK dihapus (backward compatible)
            $table->json('payment_methods')->nullable()->after('qris_image');
        });
    }

    public function down(): void
    {
        Schema::table('store_settings', function (Blueprint $table) {
            $table->dropColumn('payment_methods');
        });
    }
};
