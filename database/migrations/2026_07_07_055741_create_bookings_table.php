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
    Schema::create('booking', function (Blueprint $table) {
        $table->id('id_booking');
        $table->unsignedBigInteger('id_pelanggan');
        $table->unsignedBigInteger('id_motor');
        $table->unsignedBigInteger('id_paket');
        $table->unsignedBigInteger('id_jadwal');
        $table->date('tanggal_booking');
        $table->string('nomor_antrian', 10)->nullable();
        $table->enum('status_booking', ['Pending', 'Dikonfirmasi', 'Diproses', 'Selesai', 'Batal'])->default('Pending');
        $table->timestamps();

        // Foreign keys...
        $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan');
        $table->foreign('id_motor')->references('id_motor')->on('motor');
        $table->foreign('id_paket')->references('id_paket')->on('paket_layanan');
        $table->foreign('id_jadwal')->references('id_jadwal')->on('jadwal');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
