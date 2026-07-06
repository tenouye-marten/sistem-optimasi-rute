<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OptimasiRute extends Model
{
    use HasFactory;

    protected $fillable = [

        'kode_optimasi',

        'tanggal_generate',

        'driver_id',

        'kendaraan_id',

        'pool_id',

        'tpa_id',

        'jumlah_tps',

        'total_jarak',

        'estimasi_waktu',

        'status',

        'keterangan',

    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }

    public function tpa()
    {
        return $this->belongsTo(Tpa::class);
    }

  public function details()
{
    return $this->hasMany(
        OptimasiRuteDetail::class
    )->orderBy('urutan');
}


    public function pengangkutans()
{
    return $this->hasMany(
        Pengangkutan::class
    );
}

protected $casts = [

    'tanggal_generate' => 'date',

    'jumlah_tps' => 'integer',

    'total_jarak' => 'float',

    'estimasi_waktu' => 'integer',

];

public function scopeAktif($query)
{
    return $query->where('status','Aktif');
}

public function scopeDriver($query,$driverId)
{
    return $query->where('driver_id',$driverId);
}


}