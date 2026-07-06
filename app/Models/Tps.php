<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tps extends Model
{
    use HasFactory;

    protected $table = 'tps';

   protected $fillable = [

    'kode_tps',

    'nama_tps',

    'alamat',

    'latitude',

    'longitude',

    'kapasitas',

    'status',

];

  public function drivers()
{
    return $this->belongsToMany(
        Driver::class,
        'driver_tps'
    )->withTimestamps();
}

public function pengangkutanTps()
{
    return $this->hasMany(
        PengangkutanTps::class
    );
}


}