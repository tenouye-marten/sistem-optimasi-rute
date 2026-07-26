<?php

namespace App\Http\Controllers\KepalaDinas;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Pengangkutan;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

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

        $pengangkutans = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $allFiltered = (clone $query)->get();

        $totalPengangkutan = $allFiltered->count();

        $selesai = $allFiltered->where('status', 'Selesai')->count();

        $berjalan = $allFiltered->where('status', 'Sedang Berjalan')->count();

        $belum = $allFiltered->where('status', 'Belum Berangkat')->count();

        $totalSampah = $allFiltered->sum(function ($item) {
            return $item->total_sampah;
        });

        $totalTPS = $allFiltered->sum(function ($item) {
            return $item->details->count();
        });

        $drivers = Driver::where('status', 'Aktif')
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

        $totalSampah = $pengangkutans->sum(function ($item) {
            return $item->total_sampah;
        });

        return view(
            'kepala.laporan.print',
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

        $pengangkutans = $query->orderBy('tanggal')->get();
        $totalPengangkutan = $pengangkutans->count();

        $totalTPS = $pengangkutans->sum(function ($item) {
            return $item->details->count();
        });

        $totalSampah = $pengangkutans->sum(function ($item) {
            return $item->total_sampah;
        });

        $html = view(
            'kepala.laporan.pdf',
            compact(
                'pengangkutans',
                'tanggalAwal',
                'tanggalAkhir',
                'totalPengangkutan',
                'totalTPS',
                'totalSampah'
            )
        )->render();

        $mpdf = new Mpdf([
            'format' => 'A4-L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
        ]);

        $mpdf->SetTitle('Laporan Pengangkutan');
        $mpdf->WriteHTML($html);

        return response(
            $mpdf->Output(
                'laporan-pengangkutan.pdf',
                \Mpdf\Output\Destination::STRING_RETURN
            ),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="laporan-pengangkutan.pdf"',
            ]
        );
    }
}