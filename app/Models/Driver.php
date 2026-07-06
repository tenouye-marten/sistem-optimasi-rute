<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_driver',
        'nama',
        'nik',
        'no_hp',
        'alamat',
        'jenis_kelamin',
        'status',
    ];


   public function user()
{
    return $this->hasOne(User::class);
}

public function kendaraan()
{
    return $this->hasOne(Kendaraan::class);
}


public function tps()
{
    return $this->belongsToMany(
        Tps::class,
        'driver_tps'
    )->withTimestamps();
}

public function optimasiRutes()
{
    return $this->hasMany(
        OptimasiRute::class
    );
}

public function pengangkutans()
{
    return $this->hasMany(
        Pengangkutan::class
    );
}



}