<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Snap token dari Midtrans untuk ditampilkan ke customer
            $table->string('midtrans_snap_token', 512)->nullable()->after('tracking_number');
            // ID transaksi yang diterima dari Midtrans notification
            $table->string('midtrans_transaction_id', 100)->nullable()->after('midtrans_snap_token');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['midtrans_snap_token', 'midtrans_transaction_id']);
        });
    }
};
