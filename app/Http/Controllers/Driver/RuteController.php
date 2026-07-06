<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\OptimasiRute;
use App\Models\Pengangkutan;
use Illuminate\Support\Facades\Auth;

class RuteController extends Controller
{
    /**
     * ==========================================================
     * Daftar Rute Driver
     * ==========================================================
     */
    public function index()
    {
        $driver = Auth::user()->driver;

        $rutes = OptimasiRute::with([
                'pool',
                'tpa'
            ])
            ->where('driver_id', $driver->id)
            ->where('status', 'Aktif')
            ->latest()
            ->paginate(10);

        return view('driver.rute.index', compact(
            'rutes'
        ));
    }

    /**
     * ==========================================================
     * Detail Rute
     * ==========================================================
     */
    public function show(OptimasiRute $optimasi)
    {
        abort_if(
            $optimasi->driver_id != Auth::user()->driver->id ||
            $optimasi->status != 'Aktif',
            403
        );

        $optimasi->load([
            'pool',
            'tpa',
            'kendaraan',
            'details.tps',
        ]);

        $pengangkutan = Pengangkutan::where('driver_id', Auth::user()->driver->id)
            ->whereDate('tanggal', today())
            ->first();

        return view('driver.rute.show', compact(
            'optimasi',
            'pengangkutan'
        ));
    }
}