<?php

namespace App\Http\Controllers\KepalaDinas;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Pengangkutan;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    /**
     * ==========================================================
     * Monitoring Pengangkutan
     * ==========================================================
     */
    public function index(Request $request)
    {
        // Default ke hari ini jika tanggal tidak diisi di filter
        $tanggal = $request->tanggal ?? now()->toDateString();
        $driver  = $request->driver;
        $status  = $request->status;

        $query = Pengangkutan::with([
            'driver',
            'optimasi',
            'optimasi.kendaraan',
            'details',
        ])
        ->whereDate('tanggal', $tanggal)
        ->when($driver, function ($q) use ($driver) {
            $q->where('driver_id', $driver);
        })
        ->when($status, function ($q) use ($status) {
            $q->where('status', $status);
        });

        $pengangkutans = (clone $query)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Statistik (Sensitif Tanggal Monitoring)
        |--------------------------------------------------------------------------
        */
        $baseStat = Pengangkutan::whereDate('tanggal', $tanggal);
        if ($driver) {
            $baseStat->where('driver_id', $driver);
        }

        $totalHariIni = (clone $baseStat)->count();
        $berjalan = (clone $baseStat)->where('status', 'Sedang Berjalan')->count();
        $selesai = (clone $baseStat)->where('status', 'Selesai')->count();
        $belum = (clone $baseStat)->where('status', 'Belum Berangkat')->count();

        $drivers = Driver::where('status', 'Aktif')->orderBy('nama')->get();

        return view(
            'kepala.monitoring.index',
            compact(
                'pengangkutans',
                'drivers',
                'tanggal',
                'driver',
                'status',
                'totalHariIni',
                'berjalan',
                'selesai',
                'belum'
            )
        );
    }

    /**
     * ==========================================================
     * Detail Monitoring
     * ==========================================================
     */
    public function show(Pengangkutan $pengangkutan)
    {
        $pengangkutan->load([
            'driver',
            'optimasi',
            'optimasi.kendaraan',
            'optimasi.pool',
            'optimasi.tpa',
            'details.tps'
        ]);

        $totalTPS = $pengangkutan->details->count();
        $selesaiTPS = $pengangkutan->details->where('status', 'Selesai')->count();

        $persenMuatan = 0;

        if ($pengangkutan->status == 'Selesai') {
            $persenMuatan = 100;
        } elseif ($pengangkutan->kapasitas_kendaraan > 0) {
            $persenMuatan = round(
                ($pengangkutan->muatan_sekarang / $pengangkutan->kapasitas_kendaraan) * 100,
                2
            );
        }

        return view(
            'kepala.monitoring.show',
            compact(
                'pengangkutan',
                'totalTPS',
                'selesaiTPS',
                'persenMuatan'
            )
        );
    }
}