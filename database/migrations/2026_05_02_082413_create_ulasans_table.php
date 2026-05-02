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
        Schema::create('ulasans', function (Blueprint $table) {
            $table->id('id_ulasan');
            $table->unsignedBigInteger('id_users');
            $table->unsignedBigInteger('id_produk');
            $table->integer('rating');
            $table->text('komentar');

            $table->foreign('id_users')
                ->references('id_users')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('id_produk')
                ->references('id_produk')
                ->on('produks')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasans');
    }
};
