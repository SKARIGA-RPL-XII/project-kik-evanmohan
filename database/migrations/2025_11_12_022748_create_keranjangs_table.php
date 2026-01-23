<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keranjang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->unsignedBigInteger('variant_id')->constrained('product_variants')->onDelete('cascade');
            $table->unsignedBigInteger('size_id')->constrained('product_variant_sizes')->onDelete('cascade');

            $table->integer('qty')->default(1);
            $table->decimal('harga_satuan', 15, 2); // snapshot harga saat ditambahkan
            $table->timestamps();

            $table->unique(['user_id', 'product_id', 'variant_id', 'size_id']); // satu product hanya satu baris per user
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keranjang');
    }
};
