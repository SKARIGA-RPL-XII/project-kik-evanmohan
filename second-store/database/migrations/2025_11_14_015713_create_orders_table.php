<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('alamat_id')->nullable();
            $table->string('nama');
            $table->string('telepon');
            $table->integer('total_barang');
            $table->integer('total_harga');
            $table->integer('ongkir')->default(0);
            $table->integer('total_bayar');
            $table->string('metode_pengiriman');
            $table->string('metode_pembayaran');
            $table->string('kode_order')->unique();
            $table->enum('status', ['CANCELLED','NOT PAID', 'PAID'])->default('NOT PAID');
            $table->timestamps();

            // Foreign key ke tabel users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            // Foreign key ke tabel alamats
            $table->foreign('alamat_id')->references('id')->on('alamats')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
