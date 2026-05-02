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
        Schema::create('promos', function (Blueprint $table) {
            $table->id('id_promo');
            $table->string('kode_voucher', 50);
            $table->enum('tipe_diskon', ['persen', 'nominal']);
            $table->integer('nilai_diskon');
            $table->integer('kuota');
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_berakhir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
