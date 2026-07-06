<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    /**
     * ==========================================================
     * Mass Assignment
     * ==========================================================
     */
    protected $fillable = [

        'driver_id',

        'kode_kendaraan',

        'nama_kendaraan',

        'nomor_polisi',

        'kapasitas',

        'status',

    ];

    /**
     * ==========================================================
     * Relasi Driver
     * ==========================================================
     */

    public function driver()
    {
        return $this->belongsTo(
            Driver::class
        );
    }

    /**
     * ==========================================================
     * Relasi Optimasi Rute
     * ==========================================================
     */

    public function optimasiRutes()
    {
        return $this->hasMany(
            OptimasiRute::class
        );
    }

    /**
     * ==========================================================
     * Relasi Pengangkutan
     * ==========================================================
     */

    public function pengangkutans()
    {
        return $this->hasMany(
            Pengangkutan::class
        );
    }
}