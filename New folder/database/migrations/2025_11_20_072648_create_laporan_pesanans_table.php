<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanPesanansTable extends Migration
{
    public function up()
    {
        Schema::create('laporan_pesanans', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            $table->string('kode_order');
            $table->string('nama_pembeli');
            $table->string('telepon');
            $table->text('alamat');

            $table->integer('total_item');
            $table->integer('total_bayar');
            $table->integer('ongkir');
            $table->string('ekspedisi');

            $table->timestamp('tanggal_validasi');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_pesanans');
    }
}
