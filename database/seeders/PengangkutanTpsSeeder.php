<?php

namespace Database\Seeders;

use App\Models\PengangkutanTps;
use Illuminate\Database\Seeder;

class PengangkutanTpsSeeder extends Seeder
{
    public function run(): void
    {
        PengangkutanTps::insert([

            // ==========================
            // PNG001
            // ==========================
            [
                'pengangkutan_id' => 1,
                'tps_id' => 2,
                'urutan' => 1,
                'jarak' => 2.8,
                'berat_sampah' => 1200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pengangkutan_id' => 1,
                'tps_id' => 1,
                'urutan' => 2,
                'jarak' => 1.6,
                'berat_sampah' => 1500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pengangkutan_id' => 1,
                'tps_id' => 10,
                'urutan' => 3,
                'jarak' => 2.3,
                'berat_sampah' => 2000,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ==========================
            // PNG002
            // ==========================
            [
                'pengangkutan_id' => 2,
                'tps_id' => 5,
                'urutan' => 1,
                'jarak' => 3.4,
                'berat_sampah' => 1800,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pengangkutan_id' => 2,
                'tps_id' => 4,
                'urutan' => 2,
                'jarak' => 1.8,
                'berat_sampah' => 1200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pengangkutan_id' => 2,
                'tps_id' => 8,
                'urutan' => 3,
                'jarak' => 2.7,
                'berat_sampah' => 1300,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ==========================
            // PNG003
            // ==========================
            [
                'pengangkutan_id' => 3,
                'tps_id' => 6,
                'urutan' => 1,
                'jarak' => 2.5,
                'berat_sampah' => 2000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pengangkutan_id' => 3,
                'tps_id' => 7,
                'urutan' => 2,
                'jarak' => 1.2,
                'berat_sampah' => 1700,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pengangkutan_id' => 3,
                'tps_id' => 11,
                'urutan' => 3,
                'jarak' => 3.6,
                'berat_sampah' => 2500,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ==========================
            // PNG004
            // ==========================
            [
                'pengangkutan_id' => 4,
                'tps_id' => 2,
                'urutan' => 1,
                'jarak' => 2.0,
                'berat_sampah' => 1400,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pengangkutan_id' => 4,
                'tps_id' => 9,
                'urutan' => 2,
                'jarak' => 1.7,
                'berat_sampah' => 1200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pengangkutan_id' => 4,
                'tps_id' => 12,
                'urutan' => 3,
                'jarak' => 2.4,
                'berat_sampah' => 1500,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ==========================
            // PNG005
            // ==========================
            [
                'pengangkutan_id' => 5,
                'tps_id' => 8,
                'urutan' => 1,
                'jarak' => 2.2,
                'berat_sampah' => 1500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pengangkutan_id' => 5,
                'tps_id' => 13,
                'urutan' => 2,
                'jarak' => 3.1,
                'berat_sampah' => 1400,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pengangkutan_id' => 5,
                'tps_id' => 14,
                'urutan' => 3,
                'jarak' => 2.6,
                'berat_sampah' => 1600,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}