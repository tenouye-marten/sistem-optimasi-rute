<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptimasiRuteDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'optimasi_rute_id',
        'tps_id',
        'urutan',
        'jarak',
        'estimasi_waktu',
    ];

    protected $casts = [
        'urutan' => 'integer',
        'jarak' => 'float',
        'estimasi_waktu' => 'integer',
    ];

    public function optimasi()
    {
        return $this->belongsTo(OptimasiRute::class, 'optimasi_rute_id');
    }

    public function tps()
    {
        return $this->belongsTo(Tps::class);
    }

    public function pengangkutanDetails()
    {
        return $this->hasMany(PengangkutanDetail::class);
    }

    public function scopeUrut($query)
    {
        return $query->orderBy('urutan');
    }

    public function getJarakFormatAttribute()
    {
        return number_format($this->jarak, 2) . ' Km';
    }

    public function getEstimasiFormatAttribute()
    {
        return $this->estimasi_waktu . ' Menit';
    }
}