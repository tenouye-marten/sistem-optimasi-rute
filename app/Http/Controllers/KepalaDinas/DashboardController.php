<?php

namespace App\Http\Controllers\KepalaDinas;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Kendaraan;
use App\Models\Pengangkutan;

class DashboardController extends Controller
{
    /**
     * ==========================================================
     * Dashboard Kepala Dinas
     * ==========================================================
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Statistik
        |--------------------------------------------------------------------------
        */

        $totalDriver = Driver::count();

        $totalKendaraan = Kendaraan::count();

        $totalPengangkutan = Pengangkutan::count();

        $pengangkutanHariIni = Pengangkutan::whereDate(
            'tanggal',
            today()
        )->count();

        $sedangBerjalan = Pengangkutan::where(
            'status',
            'Sedang Berjalan'
        )->count();

        $selesai = Pengangkutan::where(
            'status',
            'Selesai'
        )->count();

        $totalSampah = Pengangkutan::sum(
            'muatan_sekarang'
        );

        /*
        |--------------------------------------------------------------------------
        | Monitoring Hari Ini
        |--------------------------------------------------------------------------
        */

        $monitoring = Pengangkutan::with([
                'driver',
                'optimasi.kendaraan'
            ])
            ->latest()
            ->take(5)
            ->get();

        return view(
            'kepala.dashboard.index',
            compact(

                'totalDriver',

                'totalKendaraan',

                'totalPengangkutan',

                'pengangkutanHariIni',

                'sedangBerjalan',

                'selesai',

                'totalSampah',

                'monitoring'

            )
        );
    }
}