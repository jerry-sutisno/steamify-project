<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Motor extends Model
{
    use SoftDeletes;
    
    protected $table = 'motor';
    protected $primaryKey = 'id_motor';
    protected $guarded = []; // Mengizinkan semua kolom diisi
}
