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
    Schema::create('paket_layanan', function (Blueprint $table) {
        $table->id('id_paket');
        $table->string('nama_paket', 50);
        $table->decimal('harga', 10, 2);
        $table->integer('estimasi_waktu'); // dalam menit
        $table->text('deskripsi')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_layanans');
    }
};
