<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropForeign(['id_promo']);
            $table->unsignedBigInteger('id_promo')->nullable()->change();
            $table->foreign('id_promo')
                ->references('id_promo')
                ->on('promos')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropForeign(['id_promo']);
            $table->unsignedBigInteger('id_promo')->nullable(false)->change();
            $table->foreign('id_promo')
                ->references('id_promo')
                ->on('promos')
                ->onDelete('cascade');
        });
    }
};
