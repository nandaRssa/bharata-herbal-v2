<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->json('benefits')->nullable();
            $table->text('ingredients')->nullable();
            $table->text('usage')->nullable();
            $table->bigInteger('price')->unsigned();
            $table->integer('stock')->default(0);
            $table->enum('category', ['jamu', 'kapsul', 'minyak', 'teh-herbal', 'lainnya']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
