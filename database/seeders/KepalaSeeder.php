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
                'name' => 'Kepala DLH',
                'password' => Hash::make('password'),
            ]
        );

        $kepala->assignRole('kepala');
    }
}