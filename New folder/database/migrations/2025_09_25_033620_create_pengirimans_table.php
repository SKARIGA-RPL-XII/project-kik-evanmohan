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
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesanan_id');   // relasi ke pesanan
            $table->unsignedBigInteger('ekspedisi_id'); // relasi ke ekspedisi
            $table->string('no_resi', 50)->nullable();
            $table->enum('status_pengiriman', ['pending', 'dikirim', 'selesai'])->default('pending');
            $table->timestamps();

            // 🔹 Foreign key
            $table->foreign('pesanan_id')
                  ->references('id')->on('pesanans')
                  ->onDelete('cascade');

            $table->foreign('ekspedisi_id')
                  ->references('id')->on('ekspedisi')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengiriman');
    }
};
