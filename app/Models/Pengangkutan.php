<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengangkutan extends Model
{
    use HasFactory;

    protected $fillable = [
        'optimasi_rute_id',
        'driver_id',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'status',
        'keterangan',
        'muatan_sekarang',
        'kapasitas_kendaraan',
        'status_perjalanan',
    ];

    protected $appends = ['total_sampah'];

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR & HELPER
    |--------------------------------------------------------------------------
    */

    /**
     * Menghitung total volume sampah yang berhasil diangkut dari detail TPS.
     * Jika status selesai dan muatan_sekarang 0, akan mengambil akumulasi volume_diangkut dari detail TPS.
     */
    public function getTotalSampahAttribute()
    {
        $fromDetails = $this->details ? $this->details->sum('volume_diangkut') : 0;
        return $fromDetails > 0 ? $fromDetails : (float) $this->muatan_sekarang;
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function optimasi()
    {
        return $this->belongsTo(OptimasiRute::class, 'optimasi_rute_id');
    }

    public function details()
    {
        return $this->hasMany(PengangkutanDetail::class)->orderBy('urutan');
    }
}