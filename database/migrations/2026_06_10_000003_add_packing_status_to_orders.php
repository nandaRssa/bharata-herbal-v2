<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * SQLite tidak enforce ENUM, jadi migration ini cukup sebagai dokumentasi.
     * Untuk MySQL: ALTER TABLE orders MODIFY COLUMN order_status
     * ENUM('new','processing','packing','shipped','delivered','cancelled') DEFAULT 'new'
     *
     * Status 'packing' (Sedang Dikemas) sudah digunakan di:
     * - Order::getStatusLabelAttribute()
     * - Order::getStatusColorAttribute()
     * - OrderAdminController::updateStatus() validation
     *
     * Migration ini memastikan konsistensi dokumentasi dan persiapan MySQL.
     */
    public function up(): void
    {
        // Untuk SQLite: tidak perlu ALTER karena ENUM tidak di-enforce
        // Kolom sudah ada sebagai TEXT/VARCHAR yang menerima nilai apapun
        // Tidak ada schema change yang diperlukan untuk SQLite

        // Untuk MySQL di masa depan, gunakan raw SQL:
        // DB::statement("ALTER TABLE orders MODIFY COLUMN order_status ENUM('new','processing','packing','shipped','delivered','cancelled') DEFAULT 'new'");
    }

    public function down(): void
    {
        // No-op: rollback tidak diperlukan karena up() tidak mengubah schema
    }
};
