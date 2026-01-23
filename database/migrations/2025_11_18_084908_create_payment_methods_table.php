<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('payment_methods', function (Blueprint $table) {
        $table->id();
        $table->string('nama_metode'); // contoh: BCA, BRI, COD, DANA
        $table->string('tipe'); // contoh: BANK, E-WALLET, COD
        $table->string('no_rekening')->nullable();
        $table->string('atas_nama')->nullable();
        $table->boolean('aktif')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
