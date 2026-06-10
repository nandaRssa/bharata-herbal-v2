<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('store_settings', function (Blueprint $table) {
            $table->dropColumn([
                'bank_bca_name', 'bank_bca_number',
                'bank_mandiri_name', 'bank_mandiri_number',
                'bank_bri_name', 'bank_bri_number',
                'dana_number', 'ovo_number', 'gopay_number',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('store_settings', function (Blueprint $table) {
            $table->string('bank_bca_name', 100)->nullable();
            $table->string('bank_bca_number', 50)->nullable();
            $table->string('bank_mandiri_name', 100)->nullable();
            $table->string('bank_mandiri_number', 50)->nullable();
            $table->string('bank_bri_name', 100)->nullable();
            $table->string('bank_bri_number', 50)->nullable();
            $table->string('dana_number', 20)->nullable();
            $table->string('ovo_number', 20)->nullable();
            $table->string('gopay_number', 20)->nullable();
        });
    }
};
