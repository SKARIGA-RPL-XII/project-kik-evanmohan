<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuktiPembayaransTable extends Migration
{
    public function up()
    {
        Schema::create('bukti_pembayarans', function (Blueprint $table) {
            $table->id();

            // Relasi ke orders
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            // File bukti transfer
            $table->string('bukti_pembayaran'); // nama file / path

            // Status verifikasi
            $table->enum('status', ['PENDING', 'VALID', 'INVALID'])->default('PENDING');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bukti_pembayarans');
    }
}
