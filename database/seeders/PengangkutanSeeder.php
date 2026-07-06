<?php

namespace Database\Seeders;

use App\Models\Pengangkutan;
use Illuminate\Database\Seeder;

class PengangkutanSeeder extends Seeder
{
    public function run(): void
    {
        Pengangkutan::insert([

            [
                'kode_pengangkutan'=>'PNG001',
                'driver_id'=>1,
                'kendaraan_id'=>1,
                'pool_id'=>1,
                'tpa_id'=>1,
                'tanggal'=>'2026-01-05',
                'jam_berangkat'=>'07:00:00',
                'jam_selesai'=>'10:15:00',
                'total_sampah'=>4700,
                'status'=>'Selesai',
                'keterangan'=>'Pengangkutan wilayah Sentani Kota',
                'created_at'=>now(),
                'updated_at'=>now(),
            ],

            [
                'kode_pengangkutan'=>'PNG002',
                'driver_id'=>2,
                'kendaraan_id'=>2,
                'pool_id'=>1,
                'tpa_id'=>1,
                'tanggal'=>'2026-01-06',
                'jam_berangkat'=>'07:15:00',
                'jam_selesai'=>'10:30:00',
                'total_sampah'=>4300,
                'status'=>'Selesai',
                'keterangan'=>'Pengangkutan wilayah Yahim',
                'created_at'=>now(),
                'updated_at'=>now(),
            ],

            [
                'kode_pengangkutan'=>'PNG003',
                'driver_id'=>3,
                'kendaraan_id'=>3,
                'pool_id'=>1,
                'tpa_id'=>1,
                'tanggal'=>'2026-01-07',
                'jam_berangkat'=>'07:10:00',
                'jam_selesai'=>'10:20:00',
                'total_sampah'=>6200,
                'status'=>'Selesai',
                'keterangan'=>'Pengangkutan wilayah Doyo',
                'created_at'=>now(),
                'updated_at'=>now(),
            ],

            [
                'kode_pengangkutan'=>'PNG004',
                'driver_id'=>4,
                'kendaraan_id'=>1,
                'pool_id'=>1,
                'tpa_id'=>1,
                'tanggal'=>'2026-01-08',
                'jam_berangkat'=>'07:05:00',
                'jam_selesai'=>'09:50:00',
                'total_sampah'=>4100,
                'status'=>'Selesai',
                'keterangan'=>'Pengangkutan wilayah Hinekombe',
                'created_at'=>now(),
                'updated_at'=>now(),
            ],

            [
                'kode_pengangkutan'=>'PNG005',
                'driver_id'=>5,
                'kendaraan_id'=>2,
                'pool_id'=>1,
                'tpa_id'=>1,
                'tanggal'=>'2026-01-09',
                'jam_berangkat'=>'07:20:00',
                'jam_selesai'=>'10:40:00',
                'total_sampah'=>4500,
                'status'=>'Selesai',
                'keterangan'=>'Pengangkutan wilayah Waibhu',
                'created_at'=>now(),
                'updated_at'=>now(),
            ],

            [
                'kode_pengangkutan'=>'PNG006',
                'driver_id'=>1,
                'kendaraan_id'=>3,
                'pool_id'=>1,
                'tpa_id'=>1,
                'tanggal'=>'2026-01-10',
                'jam_berangkat'=>'07:00:00',
                'jam_selesai'=>'10:10:00',
                'total_sampah'=>6100,
                'status'=>'Selesai',
                'keterangan'=>'Pengangkutan wilayah Ifar Besar',
                'created_at'=>now(),
                'updated_at'=>now(),
            ],

            [
                'kode_pengangkutan'=>'PNG007',
                'driver_id'=>2,
                'kendaraan_id'=>1,
                'pool_id'=>1,
                'tpa_id'=>1,
                'tanggal'=>'2026-01-11',
                'jam_berangkat'=>'07:00:00',
                'jam_selesai'=>'09:40:00',
                'total_sampah'=>3900,
                'status'=>'Selesai',
                'keterangan'=>'Pengangkutan wilayah Kemiri',
                'created_at'=>now(),
                'updated_at'=>now(),
            ],

            [
                'kode_pengangkutan'=>'PNG008',
                'driver_id'=>3,
                'kendaraan_id'=>2,
                'pool_id'=>1,
                'tpa_id'=>1,
                'tanggal'=>'2026-01-12',
                'jam_berangkat'=>'07:10:00',
                'jam_selesai'=>'10:00:00',
                'total_sampah'=>4600,
                'status'=>'Selesai',
                'keterangan'=>'Pengangkutan wilayah Harapan',
                'created_at'=>now(),
                'updated_at'=>now(),
            ],

            [
                'kode_pengangkutan'=>'PNG009',
                'driver_id'=>4,
                'kendaraan_id'=>3,
                'pool_id'=>1,
                'tpa_id'=>1,
                'tanggal'=>'2026-01-13',
                'jam_berangkat'=>'07:00:00',
                'jam_selesai'=>'10:50:00',
                'total_sampah'=>6400,
                'status'=>'Selesai',
                'keterangan'=>'Pengangkutan wilayah Waena',
                'created_at'=>now(),
                'updated_at'=>now(),
            ],

            [
                'kode_pengangkutan'=>'PNG010',
                'driver_id'=>5,
                'kendaraan_id'=>1,
                'pool_id'=>1,
                'tpa_id'=>1,
                'tanggal'=>'2026-01-14',
                'jam_berangkat'=>'07:15:00',
                'jam_selesai'=>'09:55:00',
                'total_sampah'=>4200,
                'status'=>'Selesai',
                'keterangan'=>'Pengangkutan wilayah Dobonsolo',
                'created_at'=>now(),
                'updated_at'=>now(),
            ],

        ]);
    }
}