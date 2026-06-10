<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 50)->unique();
            $table->string('customer_name');
            $table->string('customer_phone', 20);
            $table->string('customer_email')->nullable();
            $table->text('address_street');
            $table->string('address_kelurahan', 100)->nullable();
            $table->string('address_kecamatan', 100);
            $table->string('address_city', 100);
            $table->string('address_province', 100);
            $table->string('address_postal', 10);
            $table->string('shipping_method', 50);
            $table->bigInteger('shipping_cost')->unsigned()->default(0);
            $table->string('payment_method', 50);
            $table->enum('payment_status', ['pending', 'confirmed', 'failed'])->default('pending');
            $table->enum('order_status', ['new', 'processing', 'shipped', 'delivered', 'cancelled'])->default('new');
            $table->text('notes')->nullable();
            $table->bigInteger('subtotal')->unsigned();
            $table->bigInteger('total_amount')->unsigned();
            $table->string('tracking_number', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
