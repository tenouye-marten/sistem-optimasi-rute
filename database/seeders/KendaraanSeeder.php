<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;
use App\Models\Kendaraan;

class KendaraanSeeder extends Seeder
{
    public function run(): void
    {
        $drivers = Driver::all();

        foreach ($drivers as $i => $driver) {

            Kendaraan::create([

                'driver_id'=>$driver->id,

                'kode_kendaraan'=>'KDR00'.($i+1),

                'nama_kendaraan'=>'Dump Truck '.($i+1),

                'nomor_polisi'=>'PA 80'.($i+1).' JY',

                'kapasitas'=>3000,

                'status'=>'Aktif'

            ]);

        }
    }
}