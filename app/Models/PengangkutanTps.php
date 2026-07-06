<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengangkutanTps extends Model
{
    protected $table = 'pengangkutan_tps';

    protected $fillable = [

        'pengangkutan_id',

        'tps_id',

        'urutan',

        'jarak',

        'estimasi_waktu',

        'volume_diangkut',

        'waktu_tiba',

        'waktu_selesai',

        'status',

    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    public function pengangkutan()
    {
        return $this->belongsTo(
            Pengangkutan::class
        );
    }

    public function tps()
    {
        return $this->belongsTo(
            Tps::class
        );
    }
}