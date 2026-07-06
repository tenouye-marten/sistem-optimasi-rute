<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\OptimasiRute;
use App\Models\Pengangkutan;
use App\Models\PengangkutanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengangkutanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Dashboard Pengangkutan
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $driver = Auth::user()->driver;

        $pengangkutan = Pengangkutan::with([
            'optimasi.pool',
            'optimasi.tpa',
            'details.tps'
        ])
        ->where('driver_id', $driver->id)
        ->whereDate('tanggal', today())
        ->first();

        return view(
            'driver.pengangkutan.index',
            compact('driver', 'pengangkutan')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Mulai Pengangkutan
    |--------------------------------------------------------------------------
    */

    public function mulai(OptimasiRute $optimasi)
    {
        $driver = Auth::user()->driver;

        abort_if(
            $optimasi->driver_id != $driver->id,
            403
        );

        $sudahAda = Pengangkutan::where('driver_id', $driver->id)
            ->whereDate('tanggal', today())
            ->exists();

        if ($sudahAda) {

            return redirect()
                ->route('driver.pengangkutan.index')
                ->with(
                    'info',
                    'Pengangkutan hari ini sudah dimulai.'
                );

        }

        DB::transaction(function () use ($optimasi, $driver) {

            $pengangkutan = Pengangkutan::create([

                'optimasi_rute_id'      => $optimasi->id,

                'driver_id'             => $driver->id,

                'tanggal'               => today(),

                'waktu_mulai'           => now(),

                'status'                => 'Sedang Berjalan',

                'status_perjalanan'     => 'Menuju TPS',

                'kapasitas_kendaraan'   => $optimasi->kendaraan->kapasitas,

                'muatan_sekarang'       => 0,

            ]);

            foreach ($optimasi->details as $item) {

                PengangkutanDetail::create([

                    'pengangkutan_id'         => $pengangkutan->id,

                    'optimasi_rute_detail_id' => $item->id,

                    'tps_id'                  => $item->tps_id,

                    'urutan'                  => $item->urutan,

                    'volume_total'            => 0,

                    'volume_diangkut'         => 0,

                    'volume_sisa'             => 0,

                    'status'                  => 'Belum',

                ]);

            }

        });

        return redirect()
            ->route('driver.pengangkutan.index')
            ->with(
                'success',
                'Pengangkutan berhasil dimulai.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | TPS Aktif
    |--------------------------------------------------------------------------
    */

    public function tpsAktif()
    {
        $driver = Auth::user()->driver;

        $pengangkutan = Pengangkutan::with([
            'details.tps',
            'optimasi.pool',
            'optimasi.tpa'
        ])
        ->where('driver_id', $driver->id)
        ->whereDate('tanggal', today())
        ->first();

        if (! $pengangkutan) {

            return redirect()
                ->route('driver.pengangkutan.index')
                ->with(
                    'info',
                    'Belum ada pengangkutan hari ini.'
                );

        }

        /*
        |--------------------------------------------------------------------------
        | Sedang Menuju TPA
        |--------------------------------------------------------------------------
        */

        if ($pengangkutan->status_perjalanan == 'Menuju TPA') {

            return redirect()
                ->route('driver.pengangkutan.tpa');

        }

        /*
        |--------------------------------------------------------------------------
        | TPS Berikutnya
        |--------------------------------------------------------------------------
        */

        $tpsAktif = $pengangkutan->details()
            ->with('tps')
            ->whereIn('status', [

                'Belum',

                'Proses'

            ])
            ->orderBy('urutan')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Semua TPS Sudah Selesai
        |--------------------------------------------------------------------------
        */

        if (! $tpsAktif) {

            /*
            |-----------------------------------------
            | Masih ada muatan ?
            |-----------------------------------------
            */

            if ($pengangkutan->muatan_sekarang > 0) {

                $pengangkutan->update([

                    'status_perjalanan' => 'Menuju TPA'

                ]);

                return redirect()
                    ->route('driver.pengangkutan.tpa')
                    ->with(
                        'warning',
                        'Seluruh TPS selesai. Silakan menuju TPA.'
                    );

            }

            /*
            |-----------------------------------------
            | Tidak ada muatan
            |-----------------------------------------
            */

            $pengangkutan->update([

                'status'            => 'Selesai',

                'status_perjalanan' => 'Selesai',

                'waktu_selesai'     => now(),

            ]);

            return redirect()
                ->route('driver.dashboard')
                ->with(
                    'success',
                    'Pengangkutan berhasil diselesaikan.'
                );

        }

        return view(
            'driver.pengangkutan.tps',
            compact(
                'pengangkutan',
                'tpsAktif'
            )
        );
    }


    /*
|--------------------------------------------------------------------------
| Detail TPS
|--------------------------------------------------------------------------
*/

public function showTPS(PengangkutanDetail $detail)
{
    $driver = Auth::user()->driver;

    abort_if(
        $detail->pengangkutan->driver_id != $driver->id,
        403
    );

    if ($detail->status == 'Selesai') {

        return redirect()
            ->route('driver.pengangkutan.tps')
            ->with(
                'info',
                'TPS ini sudah selesai.'
            );

    }

    $detail->load([
        'tps',
        'pengangkutan'
    ]);

    $volumeInput = $detail->status == 'Proses'
        ? $detail->volume_sisa
        : null;

    return view(
        'driver.pengangkutan.show-tps',
        compact(
            'detail',
            'volumeInput'
        )
    );
}

/*
|--------------------------------------------------------------------------
| Update TPS
|--------------------------------------------------------------------------
*/

public function updateTPS(
    Request $request,
    PengangkutanDetail $detail
)
{
    $request->validate([

        'volume' => [
            'required',
            'numeric',
            'min:0.01'
        ]

    ]);

    $driver = Auth::user()->driver;

    abort_if(
        $detail->pengangkutan->driver_id != $driver->id,
        403
    );

    DB::transaction(function () use ($request, $detail) {

        $pengangkutan = $detail->pengangkutan;

        /*
        |--------------------------------------------------------------------------
        | Volume TPS
        |--------------------------------------------------------------------------
        */

        $volumeTPS = $detail->status == 'Proses'
            ? $detail->volume_sisa
            : $request->volume;

        /*
        |--------------------------------------------------------------------------
        | Sisa Kapasitas Truk
        |--------------------------------------------------------------------------
        */

        $sisaKapasitas =
            $pengangkutan->kapasitas_kendaraan
            - $pengangkutan->muatan_sekarang;

        /*
        |--------------------------------------------------------------------------
        | Muatan Masih Muat
        |--------------------------------------------------------------------------
        */

        if ($volumeTPS <= $sisaKapasitas) {

            $detail->update([

                'volume_total' => max(
                    $detail->volume_total,
                    $volumeTPS
                ),

                'volume_diangkut' =>
                    $detail->volume_diangkut
                    + $volumeTPS,

                'volume_sisa' => 0,

                'status' => 'Selesai',

                'waktu_tiba' =>
                    $detail->waktu_tiba ?? now(),

                'waktu_selesai' => now(),

            ]);

            $pengangkutan->increment(
                'muatan_sekarang',
                $volumeTPS
            );

            $pengangkutan->refresh();

            /*
            |--------------------------------------------------------------------------
            | Jika Truk Penuh
            |--------------------------------------------------------------------------
            */

            if (
                $pengangkutan->muatan_sekarang >=
                $pengangkutan->kapasitas_kendaraan
            ) {

                $pengangkutan->update([

                    'status_perjalanan' => 'Menuju TPA'

                ]);

            }

        }

        /*
        |--------------------------------------------------------------------------
        | Muatan Melebihi Kapasitas
        |--------------------------------------------------------------------------
        */

        else {

            $detail->update([

                'volume_total' => max(
                    $detail->volume_total,
                    $volumeTPS
                ),

                'volume_diangkut' =>
                    $detail->volume_diangkut
                    + $sisaKapasitas,

                'volume_sisa' =>
                    $volumeTPS - $sisaKapasitas,

                'status' => 'Proses',

                'waktu_tiba' =>
                    $detail->waktu_tiba ?? now(),

            ]);

            $pengangkutan->update([

                'muatan_sekarang' =>
                    $pengangkutan->kapasitas_kendaraan,

                'status_perjalanan' => 'Menuju TPA',

            ]);

        }

    });

    $detail->refresh();

    /*
    |--------------------------------------------------------------------------
    | Truk Penuh
    |--------------------------------------------------------------------------
    */

    if (
        $detail->pengangkutan->status_perjalanan ==
        'Menuju TPA'
    ) {

        return redirect()
            ->route('driver.pengangkutan.tpa')
            ->with(
                'warning',
                'Muatan kendaraan penuh, silakan menuju TPA.'
            );

    }

    /*
    |--------------------------------------------------------------------------
    | Lanjut TPS Berikutnya
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route('driver.pengangkutan.tps')
        ->with(
            'success',
            'Data TPS berhasil diperbarui.'
        );
}

/*
|--------------------------------------------------------------------------
| Halaman Menuju TPA
|--------------------------------------------------------------------------
*/

public function menujuTPA()
{
    $driver = Auth::user()->driver;

    $pengangkutan = Pengangkutan::with('optimasi.tpa')
        ->where('driver_id', $driver->id)
        ->whereDate('tanggal', today())
        ->first();

    if (! $pengangkutan) {

        return redirect()
            ->route('driver.pengangkutan.index')
            ->with(
                'warning',
                'Belum ada pengangkutan hari ini.'
            );

    }

    return view(
        'driver.pengangkutan.tpa',
        compact('pengangkutan')
    );
}

/*
|--------------------------------------------------------------------------
| Menuju TPA Manual
|--------------------------------------------------------------------------
*/

public function menujuTPPAManual()
{
    $driver = Auth::user()->driver;

    $pengangkutan = Pengangkutan::where(
            'driver_id',
            $driver->id
        )
        ->whereDate('tanggal', today())
        ->firstOrFail();

    $pengangkutan->update([

        'status_perjalanan' => 'Menuju TPA'

    ]);

    return redirect()
        ->route('driver.pengangkutan.tpa');
}

/*
|--------------------------------------------------------------------------
| Konfirmasi Sampai TPA
|--------------------------------------------------------------------------
*/

public function konfirmasiTPA()
{
    $driver = Auth::user()->driver;

    $pengangkutan = Pengangkutan::where(
            'driver_id',
            $driver->id
        )
        ->whereDate('tanggal', today())
        ->firstOrFail();

    DB::transaction(function () use ($pengangkutan) {

        /*
        |--------------------------------------------------------------
        | Kosongkan Muatan
        |--------------------------------------------------------------
        */

        $pengangkutan->update([

            'muatan_sekarang' => 0,

        ]);

        /*
        |--------------------------------------------------------------
        | Masih Ada TPS?
        |--------------------------------------------------------------
        */

        $masihAdaTPS = $pengangkutan->details()
            ->whereIn('status', [

                'Belum',

                'Proses'

            ])
            ->exists();

        /*
        |--------------------------------------------------------------
        | Lanjut TPS
        |--------------------------------------------------------------
        */

        if ($masihAdaTPS) {

            $pengangkutan->update([

                'status_perjalanan' => 'Menuju TPS'

            ]);

            return;

        }

        /*
        |--------------------------------------------------------------
        | Pengangkutan Selesai
        |--------------------------------------------------------------
        */

        $pengangkutan->update([

            'status' => 'Selesai',

            'status_perjalanan' => 'Selesai',

            'waktu_selesai' => now(),

        ]);

    });

    $pengangkutan->refresh();

    /*
    |--------------------------------------------------------------
    | Masih Ada TPS
    |--------------------------------------------------------------
    */

    if ($pengangkutan->status != 'Selesai') {

        return redirect()
            ->route('driver.pengangkutan.tps')
            ->with(
                'success',
                'Muatan berhasil dibuang di TPA.'
            );

    }

    /*
    |--------------------------------------------------------------
    | Semua Selesai
    |--------------------------------------------------------------
    */

    return redirect()
        ->route('driver.dashboard')
        ->with(
            'success',
            'Pengangkutan berhasil diselesaikan.'
        );
}

/*
|--------------------------------------------------------------------------
| Selesai Manual
|--------------------------------------------------------------------------
*/

public function selesai(Pengangkutan $pengangkutan)
{
    $driver = Auth::user()->driver;

    abort_if(
        $pengangkutan->driver_id != $driver->id,
        403
    );

    $masihAdaTPS = $pengangkutan->details()
        ->whereIn('status', [

            'Belum',

            'Proses'

        ])
        ->exists();

    if ($masihAdaTPS) {

        return back()
            ->with(
                'warning',
                'Masih ada TPS yang belum selesai.'
            );

    }

    if ($pengangkutan->muatan_sekarang > 0) {

        $pengangkutan->update([

            'status_perjalanan' => 'Menuju TPA'

        ]);

        return redirect()
            ->route('driver.pengangkutan.tpa')
            ->with(
                'warning',
                'Masih ada muatan. Silakan menuju TPA.'
            );

    }

    $pengangkutan->update([

        'status' => 'Selesai',

        'status_perjalanan' => 'Selesai',

        'waktu_selesai' => now(),

    ]);

    return redirect()
        ->route('driver.dashboard')
        ->with(
            'success',
            'Pengangkutan berhasil diselesaikan.'
        );
}

}