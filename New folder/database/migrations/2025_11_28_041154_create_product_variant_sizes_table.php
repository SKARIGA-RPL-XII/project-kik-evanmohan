<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variant_sizes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('variant_id');
            $table->foreign('variant_id')
                ->references('id')
                ->on('product_variants')
                ->onDelete('cascade');

            // size seperti S, M, L, XL atau angka (32, 33)
            $table->string('size', 50);

            // stok tiap size
            $table->integer('stok')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variant_sizes');
    }
};
