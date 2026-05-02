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
        Schema::create('notifikasis', function (Blueprint $table) {
            $table->id('id_notifikasi');
            $table->unsignedBigInteger('id_users');
            $table->string('judul', 150);
            $table->text('pesan');
            $table->tinyInteger('is_read')->default(0);

            $table->foreign('id_users')
                ->references('id_users')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasis');
    }
};
