<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
   public function run(): void
{
    $this->call([

        RoleSeeder::class,

        AdminSeeder::class,
       KepalaSeeder::class,
        // DriverSeeder::class,

        // KendaraanSeeder::class,

        // PoolSeeder::class,

        // TpaSeeder::class,

        // TpsSeeder::class,

        // PengangkutanSeeder::class,

        // PengangkutanTpsSeeder::class,
            // // Master Data
            // DriverSeeder::class,
            // KendaraanSeeder::class,
            // PoolSeeder::class,
            // TpaSeeder::class,
            // TpsSeeder::class,

            // // Relasi Driver - TPS
            // DriverTpsSeeder::class,

    ]);
}
}