<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Kendaraan;
use App\Models\OptimasiRute;
use App\Models\Pengangkutan;
use App\Models\Pool;
use App\Models\Tpa;
use App\Models\Tps;

class DashboardController extends Controller
{
    /**
     * ==========================================================
     * Dashboard Admin
     * ==========================================================
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Master Data
        |--------------------------------------------------------------------------
        */

        $totalDriver = Driver::count();

        $totalKendaraan = Kendaraan::count();

        $totalTPS = Tps::count();

        $totalTPA = Tpa::count();

        $totalPool = Pool::count();

        /*
        |--------------------------------------------------------------------------
        | Operasional
        |--------------------------------------------------------------------------
        */

        $totalOptimasi = OptimasiRute::count();

        $totalPengangkutan = Pengangkutan::count();

        $pengangkutanHariIni = Pengangkutan::whereDate(
            'tanggal',
            today()
        )->count();

        $pengangkutanBerjalan = Pengangkutan::where(
            'status',
            'Sedang Berjalan'
        )->count();

        $totalSampah = Pengangkutan::sum(
            'muatan_sekarang'
        );

        /*
        |--------------------------------------------------------------------------
        | Data Terbaru
        |--------------------------------------------------------------------------
        */

        $pengangkutanTerbaru = Pengangkutan::with('driver')
            ->latest()
            ->take(5)
            ->get();

        $optimasiTerbaru = OptimasiRute::with('driver')
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.dashboard.index',
            compact(

                'totalDriver',

                'totalKendaraan',

                'totalTPS',

                'totalTPA',

                'totalPool',

                'totalOptimasi',

                'totalPengangkutan',

                'pengangkutanHariIni',

                'pengangkutanBerjalan',

                'totalSampah',

                'pengangkutanTerbaru',

                'optimasiTerbaru'

            )
        );
    }
}