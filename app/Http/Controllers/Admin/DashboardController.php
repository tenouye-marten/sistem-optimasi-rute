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
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * ==========================================================
     * Dashboard Admin
     * ==========================================================
     */
    public function index(Request $request)
    {
        // Default ke hari ini jika tanggal tidak diisi
        $tanggal = $request->tanggal ?? today()->toDateString();
        $driverId = $request->driver;

        // Master Data (Total Registered)
        $totalDriver = Driver::count();
        $totalKendaraan = Kendaraan::count();
        $totalTPS = Tps::count();
        $totalTPA = Tpa::count();
        $totalPool = Pool::count();

        // Operasional (Filter Tanggal - Default Hari Ini)
        $opsQuery = Pengangkutan::with('details', 'driver', 'optimasi.kendaraan')
            ->whereDate('tanggal', $tanggal)
            ->when($driverId, function ($q) use ($driverId) {
                $q->where('driver_id', $driverId);
            });

        $pengangkutanHariIni = (clone $opsQuery)->count();
        $pengangkutanBerjalan = (clone $opsQuery)->where('status', 'Sedang Berjalan')->count();
        $pengangkutanSelesai = (clone $opsQuery)->where('status', 'Selesai')->count();

        $totalSampahPeriode = (clone $opsQuery)->get()->sum(function ($item) {
            return $item->total_sampah;
        });

        // Kumulatif Keseluruhan
        $totalOptimasi = OptimasiRute::count();
        $totalPengangkutan = Pengangkutan::count();
        $totalSampah = Pengangkutan::with('details')->get()->sum(function ($item) {
            return $item->total_sampah;
        });

        $pengangkutanTerbaru = (clone $opsQuery)->latest()->take(5)->get();
        if ($pengangkutanTerbaru->isEmpty()) {
            $pengangkutanTerbaru = Pengangkutan::with('driver')->latest()->take(5)->get();
        }

        $optimasiTerbaru = OptimasiRute::with('driver')->latest()->take(5)->get();
        $drivers = Driver::where('status', 'Aktif')->orderBy('nama')->get();

        return view(
            'admin.dashboard.index',
            compact(
                'tanggal',
                'driverId',
                'drivers',
                'totalDriver',
                'totalKendaraan',
                'totalTPS',
                'totalTPA',
                'totalPool',
                'totalOptimasi',
                'totalPengangkutan',
                'pengangkutanHariIni',
                'pengangkutanBerjalan',
                'pengangkutanSelesai',
                'totalSampahPeriode',
                'totalSampah',
                'pengangkutanTerbaru',
                'optimasiTerbaru'
            )
        );
    }
}