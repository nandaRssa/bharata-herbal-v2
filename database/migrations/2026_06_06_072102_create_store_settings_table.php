<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('store_settings', function (Blueprint $table) {
            $table->id();
            $table->string('store_name');
            $table->string('wa_number', 20)->nullable();
            $table->string('bank_bca_name', 100)->nullable();
            $table->string('bank_bca_number', 50)->nullable();
            $table->string('bank_mandiri_name', 100)->nullable();
            $table->string('bank_mandiri_number', 50)->nullable();
            $table->string('bank_bri_name', 100)->nullable();
            $table->string('bank_bri_number', 50)->nullable();
            $table->string('dana_number', 20)->nullable();
            $table->string('ovo_number', 20)->nullable();
            $table->string('gopay_number', 20)->nullable();
            $table->string('qris_image')->nullable();
            $table->text('store_address')->nullable();
            $table->string('operating_hours')->nullable();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_settings');
    }
};
