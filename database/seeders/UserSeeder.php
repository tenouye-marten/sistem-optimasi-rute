<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Driver;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */
        $admin = User::firstOrCreate(
            ['email' => 'admin@dlh.com'],
            [
                'name' => 'Administrator DLH',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');

        /*
        |--------------------------------------------------------------------------
        | KEPALA DINAS
        |--------------------------------------------------------------------------
        */
        $kepala = User::firstOrCreate(
            ['email' => 'kepala@dlh.com'],
            [
                'name' => 'Kepala Dinas DLH',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $kepala->assignRole('kepala');

        /*
        |--------------------------------------------------------------------------
        | DRIVER USERS
        |--------------------------------------------------------------------------
        */
        $firstDriver = Driver::first();

        $driverUser = User::firstOrCreate(
            ['email' => 'driver@dlh.com'],
            [
                'driver_id' => $firstDriver ? $firstDriver->id : null,
                'name' => $firstDriver ? $firstDriver->nama : 'Driver Utama',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $driverUser->assignRole('driver');

        // Seed users for other drivers
        $allDrivers = Driver::all();
        foreach ($allDrivers as $index => $drv) {
            if ($index === 0) continue;
            $email = 'driver' . ($index + 1) . '@dlh.com';
            $usr = User::firstOrCreate(
                ['email' => $email],
                [
                    'driver_id' => $drv->id,
                    'name' => $drv->nama,
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
            $usr->assignRole('driver');
        }
    }
}