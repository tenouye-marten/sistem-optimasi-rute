<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KepalaSeeder extends Seeder
{
    public function run(): void
    {
        $kepala = User::firstOrCreate(
            ['email' => 'kepala@dlh.com'],
            [
                'name' => 'Kepala Dinas',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $kepala->assignRole('kepala');
    }
}