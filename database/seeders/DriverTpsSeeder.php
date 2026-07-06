<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;
use App\Models\Tps;

class DriverTpsSeeder extends Seeder
{
    public function run(): void
    {
        $drivers = Driver::orderBy('id')->get();

        $tps = Tps::orderBy('id')->get();

        $index = 0;

        foreach ($drivers as $driver) {

            $driver->tps()->sync([

                $tps[$index]->id,
                $tps[$index + 1]->id,
                $tps[$index + 2]->id,

            ]);

            $index += 3;
        }
    }
}