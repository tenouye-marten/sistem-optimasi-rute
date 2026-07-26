<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            DriverSeeder::class,
            UserSeeder::class,
            PoolSeeder::class,
            TpaSeeder::class,
            TpsSeeder::class,
            KendaraanSeeder::class,
            DriverTpsSeeder::class,
            PengangkutanSeeder::class,
        ]);
    }
}