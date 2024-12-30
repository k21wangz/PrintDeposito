<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tanggal extends Model
{
    protected $table = 'tanggal';
    protected $fillable = ['tgl'];
    public $timestamps = false; // jika tabel tidak memiliki created_at dan updated_at
} 