<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'kode_kendaraan',
        'nama_kendaraan',
        'nomor_polisi',
        'kapasitas',
        'status',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function optimasiRutes()
    {
        return $this->hasMany(OptimasiRute::class);
    }

    public function pengangkutans()
    {
        return $this->hasMany(Pengangkutan::class);
    }
}