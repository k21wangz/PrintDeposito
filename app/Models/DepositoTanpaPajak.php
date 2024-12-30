<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepositoTanpaPajak extends Model
{
    protected $table = 'it_deposito_tanpa_pajak';
    
    protected $fillable = [
        'noacc',
        'keterangan',
        'created_by'
    ];

    public static function isTaxFree($noacc)
    {
        return static::where('noacc', $noacc)->exists();
    }
} 