<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id();

            // relasi ke pesanan
            $table->unsignedBigInteger('pesanan_id');
            $table->foreign('pesanan_id')->references('id')->on('pesanans')->onDelete('cascade');

            // relasi ke produk
            $table->unsignedBigInteger('produk_id');
            $table->foreign('produk_id')->references('id')->on('products')->onDelete('cascade');

            $table->integer('kuantiti');
            $table->string('satuan', 20)->nullable();
            $table->decimal('harga', 12, 2);
            $table->decimal('total_harga', 12, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
    }
};
