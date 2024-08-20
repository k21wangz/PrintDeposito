<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TujuanDepo extends Model
{
    use HasFactory;
    protected $fillable = ['type_tran','norek_tujuan','an_tujuan','nama_bank','noacc_depo'];
}
