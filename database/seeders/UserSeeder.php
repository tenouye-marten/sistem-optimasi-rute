<?php

namespace Database\Seeders;

use App\Models\User;
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

        $admin = User::create([

            'name' => 'Administrator',

            'email' => 'admin@dlh.go.id',

            'password' => Hash::make('password'),

            'email_verified_at' => now(),

        ]);

        $admin->assignRole('admin');


        /*
        |--------------------------------------------------------------------------
        | DRIVER
        |--------------------------------------------------------------------------
        */

        $driver = User::create([

            'name' => 'Driver DLH',

            'email' => 'driver@dlh.go.id',

            'password' => Hash::make('password'),

            'email_verified_at' => now(),

        ]);

        $driver->assignRole('driver');


        /*
        |--------------------------------------------------------------------------
        | KEPALA DINAS
        |--------------------------------------------------------------------------
        */

        $kepala = User::create([

            'name' => 'Kepala Dinas',

            'email' => 'kepala@dlh.go.id',

            'password' => Hash::make('password'),

            'email_verified_at' => now(),

        ]);

        $kepala->assignRole('kepala');

    }
}