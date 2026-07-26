<?php

namespace App\Http\Controllers\KepalaDinas;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Kendaraan;
use App\Models\Pengangkutan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * ==========================================================
     * Dashboard Kepala Dinas
     * ==========================================================
     */
    public function index(Request $request)
    {
        // Default ke hari ini jika tanggal tidak diisi
        $tanggal = $request->tanggal ?? today()->toDateString();
        $driverId = $request->driver;

        $totalDriver = Driver::count();
        $totalKendaraan = Kendaraan::count();
        $totalPengangkutan = Pengangkutan::count();

        // Operasional (Filter Tanggal - Default Hari Ini)
        $opsQuery = Pengangkutan::with('details', 'driver', 'optimasi.kendaraan')
            ->whereDate('tanggal', $tanggal)
            ->when($driverId, function ($q) use ($driverId) {
                $q->where('driver_id', $driverId);
            });

        $pengangkutanHariIni = (clone $opsQuery)->count();
        $sedangBerjalan = (clone $opsQuery)->where('status', 'Sedang Berjalan')->count();
        $selesai = (clone $opsQuery)->where('status', 'Selesai')->count();

        $totalSampahHariIni = (clone $opsQuery)->get()->sum(function ($item) {
            return $item->total_sampah;
        });

        $totalSampah = Pengangkutan::with('details')->get()->sum(function ($item) {
            return $item->total_sampah;
        });

        $monitoring = (clone $opsQuery)->latest()->take(5)->get();
        if ($monitoring->isEmpty()) {
            $monitoring = Pengangkutan::with(['driver', 'optimasi.kendaraan'])->latest()->take(5)->get();
        }

        $drivers = Driver::where('status', 'Aktif')->orderBy('nama')->get();

        return view(
            'kepala.dashboard.index',
            compact(
                'tanggal',
                'driverId',
                'drivers',
                'totalDriver',
                'totalKendaraan',
                'totalPengangkutan',
                'pengangkutanHariIni',
                'sedangBerjalan',
                'selesai',
                'totalSampahHariIni',
                'totalSampah',
                'monitoring'
            )
        );
    }
}