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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_pesanan');
            $table->string('metode_pembayaran', 150);
            $table->string('bukti_bayar', 150);
            $table->tinyInteger('status_konfirmasi')->default(0);

            $table->foreign('id_pesanan')
                ->references('id_pesanan')
                ->on('pesanans')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
