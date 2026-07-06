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
        $tanggal = $request->tanggal;
        $driver  = $request->driver;
        $status  = $request->status;

        $pengangkutans = Pengangkutan::with([

            'driver',

            'optimasi',

            'optimasi.kendaraan',

            'details',

        ])

        ->when($tanggal, function ($query) use ($tanggal) {

            $query->whereDate(
                'tanggal',
                $tanggal
            );

        })

        ->when($driver, function ($query) use ($driver) {

            $query->where(
                'driver_id',
                $driver
            );

        })

        ->when($status, function ($query) use ($status) {

            $query->where(
                'status',
                $status
            );

        })

        ->latest()

        ->paginate(10)

        ->withQueryString();

        $totalHariIni = Pengangkutan::whereDate(
            'tanggal',
            now()->toDateString()
        )->count();

        $berjalan = Pengangkutan::where(
            'status',
            'Sedang Berjalan'
        )->count();

        $selesai = Pengangkutan::where(
            'status',
            'Selesai'
        )->count();

        $belum = Pengangkutan::where(
            'status',
            'Belum Berangkat'
        )->count();

        $drivers = Driver::where(
            'status',
            'Aktif'
        )->orderBy('nama')->get();

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

        $totalTPS = $pengangkutan
            ->details
            ->count();

        $selesaiTPS = $pengangkutan
            ->details
            ->where('status', 'Selesai')
            ->count();

        $persenMuatan = 0;

        if ($pengangkutan->kapasitas_kendaraan > 0) {

            $persenMuatan = round(

                ($pengangkutan->muatan_sekarang /
                $pengangkutan->kapasitas_kendaraan) * 100,

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