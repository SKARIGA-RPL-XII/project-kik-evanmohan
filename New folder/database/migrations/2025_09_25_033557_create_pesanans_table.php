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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();

            // relasi ke users
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('ekspedisi_id');
            $table->foreign('ekspedisi_id')->references('id')->on('ekspedisi')->onDelete('cascade');


            $table->string('kode_pesanan', 20)->unique();
            $table->text('alamat_pengiriman');
            $table->string('no_hp', 20)->nullable();

            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('harga_pengiriman', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2)->default(0);

            $table->integer('kode_unik')->nullable();

            $table->enum('status_bayar', ['not paid', 'paid', 'pending'])->default('not paid');
            $table->string('bukti_pembayaran', 255)->nullable();

            $table->enum('status_verifikasi', ['manual', 'otomatis', 'belum'])->default('belum');
            $table->enum('status_pengiriman_manual', ['pending', 'dikirim', 'selesai'])->default('pending');
            $table->string('status_pengiriman_api', 50)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
