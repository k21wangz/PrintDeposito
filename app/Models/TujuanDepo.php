<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TujuanDepo extends Model
{
    use HasFactory;

    protected $table = 'tujuan_depos';
    
    protected $fillable = [
        'noacc_depo',
        'type_tran',
        'norek_tujuan',
        'an_tujuan',
        'nama_bank'
    ];

    public $timestamps = true; // jika tabel memiliki created_at dan updated_at
}
