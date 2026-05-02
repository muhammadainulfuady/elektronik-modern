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
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id('id_wishlist');
            $table->unsignedBigInteger('id_users');
            $table->unsignedBigInteger('id_produk');

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
        Schema::dropIfExists('wishlists');
    }
};
