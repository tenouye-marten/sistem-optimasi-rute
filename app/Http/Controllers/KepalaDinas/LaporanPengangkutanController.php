<?php

namespace App\Http\Controllers\KepalaDinas;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Pengangkutan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanPengangkutanController extends Controller
{
    /**
     * ==========================================================
     * Laporan Pengangkutan
     * ==========================================================
     */
    public function index(Request $request)
    {
        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;
        $driver = $request->driver;
        $status = $request->status;

        $query = Pengangkutan::with([

            'driver',

            'optimasi',

            'optimasi.kendaraan',

            'details',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Filter Tanggal
        |--------------------------------------------------------------------------
        */

        if ($tanggalAwal && $tanggalAkhir) {

            $query->whereBetween(
                'tanggal',
                [
                    $tanggalAwal,
                    $tanggalAkhir
                ]
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Filter Driver
        |--------------------------------------------------------------------------
        */

        if ($driver) {

            $query->where(
                'driver_id',
                $driver
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Filter Status
        |--------------------------------------------------------------------------
        */

        if ($status) {

            $query->where(
                'status',
                $status
            );

        }

        $pengangkutans = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Statistik
        |--------------------------------------------------------------------------
        */

        $totalPengangkutan = (clone $query)->count();

        $selesai = (clone $query)
            ->where('status', 'Selesai')
            ->count();

        $berjalan = (clone $query)
            ->where('status', 'Sedang Berjalan')
            ->count();

        $belum = (clone $query)
            ->where('status', 'Belum Berangkat')
            ->count();

        $totalSampah = (clone $query)
            ->sum('muatan_sekarang');

        $totalTPS = 0;

        foreach ($pengangkutans as $item) {

            $totalTPS += $item->details->count();

        }

        $drivers = Driver::where(
                'status',
                'Aktif'
            )
            ->orderBy('nama')
            ->get();

        return view(
            'kepala.laporan.index',
            compact(

                'pengangkutans',

                'drivers',

                'tanggalAwal',

                'tanggalAkhir',

                'driver',

                'status',

                'totalPengangkutan',

                'selesai',

                'berjalan',

                'belum',

                'totalSampah',

                'totalTPS'

            )
        );
    }

    /**
     * ==========================================================
     * Print
     * ==========================================================
     */
     /**
     * ==========================================================
     * Print
     * ==========================================================
     */
    public function print(Request $request)
{
    $tanggalAwal = $request->tanggal_awal;
    $tanggalAkhir = $request->tanggal_akhir;
    $driver = $request->driver;
    $status = $request->status;

    $query = Pengangkutan::with([
        'driver',
        'optimasi.kendaraan',
        'details'
    ]);

    if ($tanggalAwal && $tanggalAkhir) {
        $query->whereBetween('tanggal', [
            $tanggalAwal,
            $tanggalAkhir
        ]);
    }

    if ($driver) {
        $query->where('driver_id', $driver);
    }

    if ($status) {
        $query->where('status', $status);
    }

    $pengangkutans = $query->get();

    $totalPengangkutan = $pengangkutans->count();

    $totalTPS = $pengangkutans->sum(function ($item) {
        return $item->details->count();
    });

    $totalSampah = $pengangkutans->sum('muatan_sekarang');

    return view(
        'admin.laporan.print',
        compact(
            'pengangkutans',
            'tanggalAwal',
            'tanggalAkhir',
            'totalPengangkutan',
            'totalTPS',
            'totalSampah'
        )
    );
}

    /**
     * ==========================================================
     * PDF
     * ==========================================================
     */
   public function pdf(Request $request)
{
    $tanggalAwal = $request->tanggal_awal;
    $tanggalAkhir = $request->tanggal_akhir;
    $driver = $request->driver;
    $status = $request->status;

    $query = Pengangkutan::with([
        'driver',
        'optimasi.kendaraan',
        'details'
    ]);

    if ($tanggalAwal && $tanggalAkhir) {

        $query->whereBetween('tanggal', [
            $tanggalAwal,
            $tanggalAkhir
        ]);

    }

    if ($driver) {

        $query->where('driver_id', $driver);

    }

    if ($status) {

        $query->where('status', $status);

    }

    $pengangkutans = $query->get();

    $totalPengangkutan = $pengangkutans->count();

    $totalTPS = $pengangkutans->sum(function ($item) {

        return $item->details->count();

    });

    $totalSampah = $pengangkutans->sum('muatan_sekarang');

    $pdf = Pdf::loadView(

        'admin.laporan.pdf',

        compact(

            'pengangkutans',

            'tanggalAwal',

            'tanggalAkhir',

            'totalPengangkutan',

            'totalTPS',

            'totalSampah'

        )

    );

    $pdf->setPaper('A4','landscape');

    return $pdf->download('laporan-pengangkutan.pdf');
}
}