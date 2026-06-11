<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('discount_type')->nullable()->after('price');
            $table->bigInteger('discount_value')->unsigned()->nullable()->after('discount_type');
            $table->timestamp('discount_start_at')->nullable()->after('discount_value');
            $table->timestamp('discount_end_at')->nullable()->after('discount_start_at');
            $table->boolean('is_discount_active')->default(false)->after('discount_end_at');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->bigInteger('original_price')->unsigned()->nullable()->after('price');
            $table->bigInteger('discount_amount')->unsigned()->nullable()->after('original_price');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['discount_type', 'discount_value', 'discount_start_at', 'discount_end_at', 'is_discount_active']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['original_price', 'discount_amount']);
        });
    }
};
