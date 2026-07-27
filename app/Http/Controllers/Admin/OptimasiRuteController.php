<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\OptimasiRute;
use App\Models\OptimasiRuteDetail;
use App\Models\Pool;
use App\Models\Tpa;
use App\Services\NearestNeighborService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OptimasiRuteController extends Controller
{
    /**
     * ==========================================================
     * Service Nearest Neighbor
     * ==========================================================
     */
    protected NearestNeighborService $nearestNeighbor;

    public function __construct(
        NearestNeighborService $nearestNeighbor
    ) {
        $this->nearestNeighbor = $nearestNeighbor;
    }

    /**
     * ==========================================================
     * Daftar Optimasi
     * ==========================================================
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $optimasi = OptimasiRute::with([
                'driver',
                'kendaraan',
                'pool',
                'tpa',
            ])
            ->when($search, function ($query) use ($search) {

                $query->where(
                        'kode_optimasi',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhereHas('driver', function ($q) use ($search) {

                        $q->where(
                            'nama',
                            'like',
                            "%{$search}%"
                        );

                    });

            })

            ->orderByDesc('status')

            ->latest()

            ->paginate(10)

            ->withQueryString();

        return view(
            'admin.optimasi.index',
            compact(
                'optimasi',
                'search'
            )
        );
    }

    /**
     * ==========================================================
     * Form Generate Optimasi
     * ==========================================================
     */
    public function create()
    {
        $drivers = Driver::with('kendaraan')

            ->where('status', 'Aktif')

            ->orderBy('nama')

            ->get();

        $pools = Pool::where('status', 'Aktif')

            ->orderBy('nama_pool')

            ->get();

        $tpas = Tpa::where('status', 'Aktif')

            ->orderBy('nama_tpa')

            ->get();

        return view(
            'admin.optimasi.create',
            compact(
                'drivers',
                'pools',
                'tpas'
            )
        );
    }

    /**
     * ==========================================================
     * AJAX Informasi Driver
     * ==========================================================
     */
    public function driverInfo(Driver $driver)
    {
        $driver->load([
            'kendaraan',
            'tps',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Driver belum memiliki kendaraan
        |--------------------------------------------------------------------------
        */

        if (!$driver->kendaraan) {

            return response()->json([

                'success' => false,

                'message' => 'Driver belum memiliki kendaraan.'

            ], 422);

        }

        /*
        |--------------------------------------------------------------------------
        | Driver belum memiliki TPS
        |--------------------------------------------------------------------------
        */

        if ($driver->tps->count() == 0) {

            return response()->json([

                'success' => false,

                'message' => 'Driver belum memiliki wilayah TPS.'

            ], 422);

        }

        /*
        |--------------------------------------------------------------------------
        | Informasi Driver
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'driver' => $driver,

            'kendaraan' => $driver->kendaraan,

            'jumlah_tps' => $driver->tps->count(),

            'tps' => $driver->tps,

            /*
            |--------------------------------------------------------------
            | Informasi Optimasi Aktif
            |--------------------------------------------------------------
            */

            'optimasi_aktif' => OptimasiRute::where(
                    'driver_id',
                    $driver->id
                )
                ->where(
                    'status',
                    'Aktif'
                )
                ->first(),

        ]);
    }


    /**
 * ==========================================================
 * Generate Optimasi Rute
 * ==========================================================
 */
public function store(Request $request)
{
    $request->validate([

        'driver_id' => 'required|exists:drivers,id',

        'pool_id'   => 'required|exists:pools,id',

        'tpa_id'    => 'required|exists:tpas,id',

    ]);

    /*
    |--------------------------------------------------------------------------
    | Ambil Driver
    |--------------------------------------------------------------------------
    */

    $driver = Driver::with([
        'kendaraan',
        'tps'
    ])->findOrFail($request->driver_id);

    /*
    |--------------------------------------------------------------------------
    | Validasi Kendaraan
    |--------------------------------------------------------------------------
    */

    if (!$driver->kendaraan) {

        return back()
            ->withInput()
            ->withErrors([
                'driver_id' => 'Driver belum memiliki kendaraan.'
            ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Validasi TPS
    |--------------------------------------------------------------------------
    */

    if ($driver->tps->count() == 0) {

        return back()
            ->withInput()
            ->withErrors([
                'driver_id' => 'Driver belum memiliki wilayah TPS.'
            ]);

    }

    $pool = Pool::findOrFail($request->pool_id);

    $tpa = Tpa::findOrFail($request->tpa_id);

    $optimasi = null;

    DB::transaction(function () use (

        &$optimasi,
        $driver,
        $pool,
        $tpa

    ) {

        /*
        |--------------------------------------------------------------------------
        | Nonaktifkan Optimasi Lama Driver
        |--------------------------------------------------------------------------
        */

        OptimasiRute::where(
            'driver_id',
            $driver->id
        )
        ->where(
            'status',
            'Aktif'
        )
        ->update([

            'status' => 'Tidak Aktif'

        ]);

        /*
        |--------------------------------------------------------------------------
        | Generate Kode
        |--------------------------------------------------------------------------
        */

        $existingKodes = OptimasiRute::pluck('kode_optimasi')->map(fn($k) => trim($k))->toArray();
        $maxNomor = 0;
        foreach ($existingKodes as $k) {
            if (preg_match('/(\d+)/', $k, $match)) {
                $num = (int) $match[1];
                if ($num > $maxNomor) {
                    $maxNomor = $num;
                }
            }
        }

        $nomor = $maxNomor + 1;

        do {
            $kode = 'OPT' . str_pad($nomor, 4, '0', STR_PAD_LEFT);
            $nomor++;
        } while (
            in_array($kode, $existingKodes) ||
            OptimasiRute::where('kode_optimasi', $kode)->orWhere('kode_optimasi', 'like', $kode . '%')->exists()
        );

        /*
        |--------------------------------------------------------------------------
        | Jalankan Algoritma Nearest Neighbor
        |--------------------------------------------------------------------------
        */

        $hasil = $this->nearestNeighbor->generate(

            $driver,

            $pool,

            $tpa

        );

        /*
        |--------------------------------------------------------------------------
        | Simpan Header Optimasi
        |--------------------------------------------------------------------------
        */

        $optimasi = OptimasiRute::create([

            'kode_optimasi' => $kode,

            'tanggal_generate' => today(),

            'driver_id' => $driver->id,

            'kendaraan_id' => $driver->kendaraan->id,

            'pool_id' => $pool->id,

            'tpa_id' => $tpa->id,

            'jumlah_tps' => count($hasil['rute']),

            'total_jarak' => $hasil['total_jarak'],

            'estimasi_waktu' => $hasil['estimasi_waktu'],

            'status' => 'Aktif',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Simpan Detail Rute
        |--------------------------------------------------------------------------
        */

        foreach ($hasil['rute'] as $item) {

            OptimasiRuteDetail::create([

                'optimasi_rute_id' => $optimasi->id,

                'tps_id' => $item['tps']->id,

                'urutan' => $item['urutan'],

                'jarak' => $item['jarak'],

                'estimasi_waktu' => round(
                    $item['jarak'] * 3
                ),

            ]);

        }

    });

    return redirect()

        ->route(
            'admin.optimasi.show',
            $optimasi
        )

        ->with(
            'success',
            'Optimasi rute berhasil dibuat dan menjadi rute aktif driver.'
        );
}

/**
 * ==========================================================
 * Detail Optimasi
 * ==========================================================
 */
public function show(OptimasiRute $optimasi)
{
    $optimasi->load([

        'driver',

        'kendaraan',

        'pool',

        'tpa',

        'details.tps',

    ]);

    return view(
        'admin.optimasi.show',
        compact('optimasi')
    );
}


/**
 * ==========================================================
 * Hapus Optimasi
 * ==========================================================
 */
public function destroy(OptimasiRute $optimasi)
{
    /*
    |--------------------------------------------------------------------------
    | Optimasi sudah pernah digunakan?
    |--------------------------------------------------------------------------
    */

    if ($optimasi->pengangkutans()->exists()) {

        return redirect()

            ->route('admin.optimasi.index')

            ->with(

                'warning',

                'Optimasi sudah digunakan pada pengangkutan sehingga tidak dapat dihapus.'

            );

    }

    DB::transaction(function () use ($optimasi) {

        $optimasi->details()->delete();

        $optimasi->delete();

    });

    return redirect()

        ->route('admin.optimasi.index')

        ->with(

            'success',

            'Optimasi berhasil dihapus.'

        );
}


/**
 * ==========================================================
 * Edit
 * ==========================================================
 */
public function edit(OptimasiRute $optimasi)
{
    return redirect()

        ->route('admin.optimasi.show', $optimasi)

        ->with(

            'info',

            'Optimasi tidak dapat diedit. Silakan Generate Optimasi kembali jika terdapat perubahan data.'

        );
}


/**
 * ==========================================================
 * Update
 * ==========================================================
 */
public function update(
    Request $request,
    OptimasiRute $optimasi
)
{
    return redirect()

        ->route('admin.optimasi.show', $optimasi)

        ->with(

            'info',

            'Optimasi tidak dapat diperbarui. Gunakan Generate Optimasi untuk membuat rute terbaru.'

        );
}

}