<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Pengangkutan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * ==========================================================
     * Dashboard Driver
     * ==========================================================
     */
    public function index()
    {
        $driver = Auth::user()->driver;

        /*
        |--------------------------------------------------------------------------
        | Pengangkutan Hari Ini
        |--------------------------------------------------------------------------
        */

        $pengangkutan = Pengangkutan::with([

            'optimasi.kendaraan',

            'optimasi.pool',

            'optimasi.tpa',

            'details'

        ])

        ->where('driver_id', $driver->id)

        ->whereDate('tanggal', today())

        ->first();

        /*
        |--------------------------------------------------------------------------
        | Kendaraan
        |--------------------------------------------------------------------------
        */

        $kendaraan = $pengangkutan?->optimasi?->kendaraan;

        /*
        |--------------------------------------------------------------------------
        | Statistik
        |--------------------------------------------------------------------------
        */

        $totalTPS = $pengangkutan
            ? $pengangkutan->details->count()
            : 0;

        $tpsSelesai = $pengangkutan
            ? $pengangkutan->details
                ->where('status', 'Selesai')
                ->count()
            : 0;

        $muatan = $pengangkutan?->muatan_sekarang ?? 0;

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'driver.dashboard.index',
            compact(

                'driver',

                'kendaraan',

                'pengangkutan',

                'totalTPS',

                'tpsSelesai',

                'muatan'

            )
        );
    }
}