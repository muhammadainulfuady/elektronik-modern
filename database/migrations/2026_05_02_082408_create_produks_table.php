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
        Schema::create('produks', function (Blueprint $table) {
            $table->id('id_produk');
            $table->unsignedBigInteger('id_kategori');
            $table->string('gambar', 50);
            $table->string('nama_produk', 50);
            $table->text('deskripsi');
            $table->integer('harga');
            $table->integer('stok');

            $table->foreign('id_kategori')
                ->references('id_kategori')
                ->on('kategoris')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
