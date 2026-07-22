<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';
    protected $primaryKey = 'id_booking';
    protected $guarded = [];

    // Relasi untuk memanggil data terkait nanti
    public function pelanggan() { return $this->belongsTo(Pelanggan::class, 'id_pelanggan'); }
    public function motor() { return $this->belongsTo(Motor::class, 'id_motor')->withTrashed(); }
    public function paket() { return $this->belongsTo(PaketLayanan::class, 'id_paket'); }
    public function jadwal() { return $this->belongsTo(Jadwal::class, 'id_jadwal'); }
    public function transaksi() { return $this->hasOne(Transaksi::class, 'id_booking'); }
}