<?php

namespace App\Models;

// Perhatikan: Karena Pelanggan dipakai untuk fitur Login, kita harus extends ke Authenticatable
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use Notifiable;

    // 1. Beritahu Laravel nama tabel aslinya
    protected $table = 'pelanggan';
    
    // 2. Beritahu Laravel nama primary key aslinya
    protected $primaryKey = 'id_pelanggan';

    // 3. Kolom apa saja yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'nama', 
        'email', 
        'no_hp', 
        'password'
    ];

    // 4. Sembunyikan password saat data dipanggil
    protected $hidden = [
        'password',
    ];

    // Relasi
    public function motors() {
        return $this->hasMany(Motor::class, 'id_pelanggan');
    }

    public function bookings() {
        return $this->hasMany(Booking::class, 'id_pelanggan');
    }
}