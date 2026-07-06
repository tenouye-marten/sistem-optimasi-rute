<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tpa extends Model
{
    use HasFactory;

    protected $fillable = [

        'kode_tpa',

        'nama_tpa',

        'alamat',

        'latitude',

        'longitude',

        'kapasitas',

        'status'

    ];

    public function pengangkutans()
{
    return $this->hasMany(Pengangkutan::class);
}


public function optimasiRutes()
{
    return $this->hasMany(
        OptimasiRute::class
    );
}
}