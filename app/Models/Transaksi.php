<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $guarded = [];

    public function booking() { return $this->belongsTo(Booking::class, 'id_booking'); }
}
