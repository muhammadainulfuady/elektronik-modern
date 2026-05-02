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
        Schema::create('dusuns', function (Blueprint $table) {
            $table->id('id_dusun');
            $table->unsignedBigInteger('id_desa');
            $table->string('nama_dusun', 50);

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
        Schema::dropIfExists('dusuns');
    }
};
