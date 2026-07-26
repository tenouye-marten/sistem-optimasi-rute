<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tpa;

class TpaSeeder extends Seeder
{
    public function run(): void
    {
        Tpa::firstOrCreate(
            ['kode_tpa' => 'TPA001'],
            [
                'nama_tpa'  => 'TPA Waibron',
                'alamat'    => 'Waibron, Sentani Barat',
                'latitude'  => -2.495800,
                'longitude' => 140.377600,
                'status'    => 'Aktif',
            ]
        );
    }
}