<?php

namespace App\Services;

use App\Models\Driver;
use App\Models\Pool;
use App\Models\Tpa;

class NearestNeighborService
{
    /**
     * Estimasi waktu (menit) per kilometer
     */
    const MENIT_PER_KM = 3;

    /**
     * Generate Optimasi Rute
     */
    public function generate(
        Driver $driver,
        Pool $pool,
        Tpa $tpa
    ): array {

        // Semua TPS milik driver
        $tpsList = $driver->tps()->get()->all();

        $rute = [];

        $totalJarak = 0;

        $currentLat = $pool->latitude;
        $currentLng = $pool->longitude;

        $urutan = 1;

        /*
        |--------------------------------------------------------------------------
        | Nearest Neighbor
        |--------------------------------------------------------------------------
        */

        while (count($tpsList) > 0) {

            $nearest = $this->findNearest(
                $currentLat,
                $currentLng,
                $tpsList
            );

            $rute[] = [

                'urutan' => $urutan,

                'tps' => $nearest,

                'nama' => $nearest->nama_tps,

                'latitude' => $nearest->latitude,

                'longitude' => $nearest->longitude,

                'jarak' => $nearest->jarak,

                'estimasi_waktu' => round(
                    $nearest->jarak * self::MENIT_PER_KM
                ),

            ];

            $totalJarak += $nearest->jarak;

            $currentLat = $nearest->latitude;
            $currentLng = $nearest->longitude;

            foreach ($tpsList as $key => $item) {

                if ($item->id == $nearest->id) {

                    unset($tpsList[$key]);

                    break;
                }
            }

            $tpsList = array_values($tpsList);

            $urutan++;
        }

        /*
        |--------------------------------------------------------------------------
        | Jarak TPS Terakhir ke TPA
        |--------------------------------------------------------------------------
        */

        $jarakKeTpa = $this->haversine(
            $currentLat,
            $currentLng,
            $tpa->latitude,
            $tpa->longitude
        );

        $totalJarak += $jarakKeTpa;

        $estimasi = round(
            $totalJarak * self::MENIT_PER_KM
        );

        /*
        |--------------------------------------------------------------------------
        | Return Hasil Optimasi
        |--------------------------------------------------------------------------
        */

        return [

            'pool' => [

                'nama' => $pool->nama_pool,

                'latitude' => $pool->latitude,

                'longitude' => $pool->longitude,

            ],

            'tpa' => [

                'nama' => $tpa->nama_tpa,

                'latitude' => $tpa->latitude,

                'longitude' => $tpa->longitude,

                'jarak_dari_tps_terakhir' => round($jarakKeTpa, 2),

            ],

            'jumlah_tps' => count($rute),

            'rute' => $rute,

            'total_jarak' => round($totalJarak, 2),

            'estimasi_waktu' => $estimasi,

        ];
    }

    /**
     * Menghitung jarak dua koordinat
     * menggunakan Haversine Formula.
     *
     * Return : Kilometer
     */
    private function haversine(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2
    ): float {

        $earthRadius = 6371;

        $dLat = deg2rad($lat2 - $lat1);

        $dLon = deg2rad($lon2 - $lon1);

        $a =
            sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) *
            cos(deg2rad($lat2)) *
            sin($dLon / 2) *
            sin($dLon / 2);

        $c = 2 * atan2(
            sqrt($a),
            sqrt(1 - $a)
        );

        return round(
            $earthRadius * $c,
            2
        );
    }

    /**
     * Mencari TPS dengan jarak terdekat
     */
    private function findNearest(
        float $currentLat,
        float $currentLng,
        array $tpsList
    ) {

        $nearest = null;

        $minDistance = PHP_FLOAT_MAX;

        foreach ($tpsList as $tps) {

            $distance = $this->haversine(
                $currentLat,
                $currentLng,
                $tps->latitude,
                $tps->longitude
            );

            if ($distance < $minDistance) {

                $minDistance = $distance;

                $nearest = $tps;

                $nearest->jarak = $distance;
            }
        }

        return $nearest;
    }
}