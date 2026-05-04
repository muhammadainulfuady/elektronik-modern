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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->unsignedBigInteger('id_users');
            $table->unsignedBigInteger('id_alamat');
            $table->unsignedBigInteger('id_promo');
            $table->unsignedBigInteger('id_ekspedisi');
            $table->dateTime('tanggal_pesan');
            $table->integer('subtotal');
            $table->integer('diskon');
            $table->string('no_resi', 50);
            $table->integer('ongkos_kirim');
            $table->integer('total_bayar');
            $table->enum('status_pesanan', ['diproses', 'dikirim', 'selesai']);

            $table->foreign('id_users')
                ->references('id_users')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('id_alamat')
                ->references('id_alamat')
                ->on('alamat_users')
                ->onDelete('cascade');
            $table->foreign('id_promo')
                ->references('id_promo')
                ->on('promos')
                ->onDelete('cascade');
            $table->foreign('id_ekspedisi')
                ->references('id_ekspedisi')
                ->on('ekspedisis')
                ->onDelete('cascade');
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
