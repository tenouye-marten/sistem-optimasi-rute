<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengangkutanDetail extends Model
{
    protected $fillable = [

        'pengangkutan_id',

        'optimasi_rute_detail_id',

        'tps_id',

        'urutan',

        'volume_total',

        'volume_diangkut',

        'volume_sisa',

        'waktu_tiba',

        'waktu_selesai',

        'status',

    ];

    public function pengangkutan()
    {
        return $this->belongsTo(Pengangkutan::class);
    }

    public function tps()
    {
        return $this->belongsTo(Tps::class);
    }

    public function optimasiDetail()
    {
        return $this->belongsTo(
            OptimasiRuteDetail::class,
            'optimasi_rute_detail_id'
        );
    }
}