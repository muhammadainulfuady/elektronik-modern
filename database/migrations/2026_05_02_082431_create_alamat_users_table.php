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
        Schema::create('alamat_users', function (Blueprint $table) {
            $table->id('id_alamat');
            $table->unsignedBigInteger('id_users');
            $table->unsignedBigInteger('id_desa');
            $table->string('label_alamat', 50);
            $table->string('nomor_telepon', 20);
            $table->string('detail_alamat', 255);
            $table->tinyInteger('is_utama')->default(0);

            $table->foreign('id_users')
                ->references('id_users')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('id_desa')
                ->references('id_desa')
                ->on('desas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamat_users');
    }
};
