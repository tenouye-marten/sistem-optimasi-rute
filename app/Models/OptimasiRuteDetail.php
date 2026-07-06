<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OptimasiRuteDetail extends Model
{
    use HasFactory;

    /**
     * ==========================================================
     * Mass Assignment
     * ==========================================================
     */
    protected $fillable = [

        'optimasi_rute_id',

        'tps_id',

        'urutan',

        'jarak',

        'estimasi_waktu',

    ];

    /**
     * ==========================================================
     * Attribute Casting
     * ==========================================================
     */
    protected $casts = [

        'urutan'           => 'integer',

        'jarak'            => 'float',

        'estimasi_waktu'   => 'integer',

    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    /**
     * Optimasi Rute
     */
    public function optimasi()
    {
        return $this->belongsTo(
            OptimasiRute::class,
            'optimasi_rute_id'
        );
    }

    /**
     * TPS
     */
    public function tps()
    {
        return $this->belongsTo(Tps::class);
    }

    /**
     * Detail Pengangkutan
     */
    public function pengangkutanDetails()
    {
        return $this->hasMany(
            PengangkutanDetail::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | QUERY SCOPE
    |--------------------------------------------------------------------------
    */

    /**
     * Urut berdasarkan nomor rute
     */
    public function scopeUrut($query)
    {
        return $query->orderBy('urutan');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */

    /**
     * Format Jarak
     */
    public function getJarakFormatAttribute()
    {
        return number_format(
            $this->jarak,
            2
        ) . ' Km';
    }

    /**
     * Format Estimasi
     */
    public function getEstimasiFormatAttribute()
    {
        return $this->estimasi_waktu . ' Menit';
    }
}