<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drivers = [
            [
                'kode_driver'   => 'DRV001',
                'nama'          => 'Yohanis Wenda',
                'nik'           => '9103010101010001',
                'no_hp'         => '081111111111',
                'alamat'        => 'Sentani, Kabupaten Jayapura',
                'jenis_kelamin' => 'L',
                'status'        => 'Aktif',
            ],
            [
                'kode_driver'   => 'DRV002',
                'nama'          => 'Markus Yoku',
                'nik'           => '9103010101010002',
                'no_hp'         => '082222222222',
                'alamat'        => 'Hinekombe, Kabupaten Jayapura',
                'jenis_kelamin' => 'L',
                'status'        => 'Aktif',
            ],
            [
                'kode_driver'   => 'DRV003',
                'nama'          => 'Samuel Wally',
                'nik'           => '9103010101010003',
                'no_hp'         => '083333333333',
                'alamat'        => 'Dobonsolo, Kabupaten Jayapura',
                'jenis_kelamin' => 'L',
                'status'        => 'Aktif',
            ],
            [
                'kode_driver'   => 'DRV004',
                'nama'          => 'Petrus Kogoya',
                'nik'           => '9103010101010004',
                'no_hp'         => '084444444444',
                'alamat'        => 'Kemiri, Kabupaten Jayapura',
                'jenis_kelamin' => 'L',
                'status'        => 'Aktif',
            ],
            [
                'kode_driver'   => 'DRV005',
                'nama'          => 'Yakobus Mote',
                'nik'           => '9103010101010005',
                'no_hp'         => '085555555555',
                'alamat'        => 'Doyo Baru, Kabupaten Jayapura',
                'jenis_kelamin' => 'L',
                'status'        => 'Aktif',
            ],
        ];

        foreach ($drivers as $driverData) {
            Driver::firstOrCreate(
                ['kode_driver' => $driverData['kode_driver']],
                $driverData
            );
        }
    }
}