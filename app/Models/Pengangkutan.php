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

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    public function driver()
    {
        return $this->belongsTo(
            Driver::class
        );
    }

    public function optimasi()
    {
        return $this->belongsTo(
            OptimasiRute::class,
            'optimasi_rute_id'
        );
    }

    public function details()
{
    return $this->hasMany(
        PengangkutanDetail::class
    )->orderBy('urutan');
}
    
}