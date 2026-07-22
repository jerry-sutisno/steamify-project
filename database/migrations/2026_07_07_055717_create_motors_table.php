<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
    Schema::create('motor', function (Blueprint $table) {
        $table->id('id_motor');
        $table->unsignedBigInteger('id_pelanggan');
        $table->string('plat_nomor', 15);
        $table->string('merk_motor', 50);
        $table->string('tipe_motor', 50);
        $table->string('warna_motor', 30);
        $table->timestamps();

        $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motors');
    }
};
