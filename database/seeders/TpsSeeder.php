<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tps;

class TpsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kode_tps' => 'TPS001',
                'nama_tps' => 'TPS Pasar Pharaa Sentani',
                'alamat' => 'Jl. Pasar Pharaa, Sentani Kota, Kabupaten Jayapura',
                'latitude' => -2.5666875,
                'longitude' => 140.5205625,
                'kapasitas' => 1200,
                'status' => 'Aktif',
            ],
            [
                'kode_tps' => 'TPS002',
                'nama_tps' => 'TPS Nendali',
                'alamat' => 'Nendali, Kec. Sentani Timur, Kabupaten Jayapura',
                'latitude' => -2.5778375,
                'longitude' => 140.5419531,
                'kapasitas' => 850,
                'status' => 'Aktif',
            ],
            [
                'kode_tps' => 'TPS003',
                'nama_tps' => 'TPS Pos 7 Sentani',
                'alamat' => 'Pos 7 Sentani Kota, Kabupaten Jayapura',
                'latitude' => -2.5698125,
                'longitude' => 140.5258125,
                'kapasitas' => 900,
                'status' => 'Aktif',
            ],
            [
                'kode_tps' => 'TPS004',
                'nama_tps' => 'TPS Hawai Sentani',
                'alamat' => 'Hawai, Sentani Kota, Kabupaten Jayapura',
                'latitude' => -2.5696125,
                'longitude' => 140.5255781,
                'kapasitas' => 1000,
                'status' => 'Aktif',
            ],
            [
                'kode_tps' => 'TPS005',
                'nama_tps' => 'TPS Stasion Bus Sentani',
                'alamat' => 'Stasion Bus Sentani Kota, Kabupaten Jayapura',
                'latitude' => -2.5659125,
                'longitude' => 140.5147969,
                'kapasitas' => 800,
                'status' => 'Aktif',
            ],
            [
                'kode_tps' => 'TPS006',
                'nama_tps' => 'TPS Hinekombe',
                'alamat' => 'Hinekombe, Kabupaten Jayapura',
                'latitude' => -2.5646875,
                'longitude' => 140.5058125,
                'kapasitas' => 950,
                'status' => 'Aktif',
            ],
            [
                'kode_tps' => 'TPS007',
                'nama_tps' => 'TPS Doyo Baru',
                'alamat' => 'Doyo Baru, Kec. Waabu, Kabupaten Jayapura',
                'latitude' => -2.5628375,
                'longitude' => 140.5171094,
                'kapasitas' => 1100,
                'status' => 'Aktif',
            ],
            [
                'kode_tps' => 'TPS008',
                'nama_tps' => 'TPS Kemiri Sentani',
                'alamat' => 'Jl. Raya Kemiri, Sentani Kota, Kabupaten Jayapura',
                'latitude' => -2.5655201,
                'longitude' => 140.5144110,
                'kapasitas' => 750,
                'status' => 'Aktif',
            ],
        ];

        foreach ($data as $tpsItem) {
            Tps::firstOrCreate(
                ['kode_tps' => $tpsItem['kode_tps']],
                $tpsItem
            );
        }
    }
}