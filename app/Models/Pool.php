<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pool extends Model
{
    use HasFactory;

    protected $fillable = [

        'kode_pool',

        'nama_pool',

        'alamat',

        'latitude',

        'longitude',

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