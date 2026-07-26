<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pool;

class PoolSeeder extends Seeder
{
    public function run(): void
    {
        Pool::firstOrCreate(
            ['kode_pool' => 'POL001'],
            [
                'nama_pool' => 'Pool DLH Kabupaten Jayapura',
                'alamat'    => 'Kantor DLH Kabupaten Jayapura, Gunung Merah, Sentani',
                'latitude'  => -2.571550,
                'longitude' => 140.512400,
                'status'    => 'Aktif',
            ]
        );
    }
}