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

        if ($drivers->isEmpty() || $tps->isEmpty()) {
            return;
        }

        $totalTps = $tps->count();
        $index = 0;

        foreach ($drivers as $driver) {
            $assignedTpsIds = [];

            for ($i = 0; $i < 3; $i++) {
                if (isset($tps[$index % $totalTps])) {
                    $assignedTpsIds[] = $tps[$index % $totalTps]->id;
                }
                $index++;
            }

            if (!empty($assignedTpsIds)) {
                $driver->tps()->sync($assignedTpsIds);
            }
        }
    }
}