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
            $kode = 'KDR00' . ($i + 1);

            Kendaraan::firstOrCreate(
                ['kode_kendaraan' => $kode],
                [
                    'driver_id' => $driver->id,
                    'nama_kendaraan' => 'Dump Truck ' . sprintf('%02d', $i + 1),
                    'nomor_polisi' => 'PA 80' . ($i + 1) . ' JY',
                    'kapasitas' => 3000 + ($i * 500),
                    'status' => 'Aktif',
                ]
            );
        }
    }
}