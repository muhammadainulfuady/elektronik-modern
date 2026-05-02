<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_keranjangs', function (Blueprint $table) {
            $table->id('id_detail_keranjang');
            $table->unsignedBigInteger('id_produk');
            $table->unsignedBigInteger('id_keranjang');
            $table->integer('qty');

            $table->foreign('id_produk')
                ->references('id_produk')
                ->on('produks')
                ->onDelete('cascade');
            $table->foreign('id_keranjang')
                ->references('id_keranjang')
                ->on('keranjangs')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_keranjangs');
    }
};
