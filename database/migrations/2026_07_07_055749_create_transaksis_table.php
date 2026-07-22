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
    Schema::create('transaksi', function (Blueprint $table) {
        $table->id('id_transaksi');
        $table->unsignedBigInteger('id_booking')->unique();
        $table->string('nomor_struk', 30)->unique();
        $table->enum('metode_bayar', ['Transfer Bank', 'QRIS', 'E-Wallet', 'Tunai']);
        $table->dateTime('tanggal_bayar')->nullable();
        $table->decimal('total_bayar', 10, 2);
        $table->enum('status_bayar', ['Belum Bayar', 'Lunas', 'Gagal'])->default('Belum Bayar');
        $table->timestamps();

        $table->foreign('id_booking')->references('id_booking')->on('booking')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
