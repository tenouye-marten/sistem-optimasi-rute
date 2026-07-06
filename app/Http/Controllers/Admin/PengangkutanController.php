<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Pengangkutan;
use App\Models\PengangkutanTps;
use App\Models\Pool;
use App\Models\Tpa;
use App\Services\NearestNeighborService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PengangkutanController extends Controller
{
    protected NearestNeighborService $nearestNeighbor;

    public function __construct(NearestNeighborService $nearestNeighbor)
    {
        $this->nearestNeighbor = $nearestNeighbor;
    }

    /**
     * ==========================================================
     * Daftar Pengangkutan
     * ==========================================================
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $pengangkutans = Pengangkutan::with([
                'driver',
                'kendaraan',
                'pool',
                'tpa'
            ])
            ->when($search, function ($query) use ($search) {

                $query->where('kode_pengangkutan', 'like', "%{$search}%")
                    ->orWhereHas('driver', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    });

            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.pengangkutan.index',
            compact(
                'pengangkutans',
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
        $drivers = Driver::where('status', 'Aktif')
            ->orderBy('nama')
            ->get();

        $pools = Pool::where('status', 'Aktif')
            ->orderBy('nama_pool')
            ->get();

        $tpas = Tpa::where('status', 'Aktif')
            ->orderBy('nama_tpa')
            ->get();

        return view(
            'admin.pengangkutan.create',
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
            'tps'
        ]);

        if (!$driver->kendaraan) {

            return response()->json([
                'success' => false,
                'message' => 'Driver belum memiliki kendaraan.'
            ], 422);

        }

        return response()->json([

            'success' => true,

            'driver' => [

                'id' => $driver->id,

                'kode_driver' => $driver->kode_driver,

                'nama' => $driver->nama,

                'nik' => $driver->nik,

                'no_hp' => $driver->no_hp,

            ],

            'kendaraan' => [

                'id' => $driver->kendaraan->id,

                'kode_kendaraan' => $driver->kendaraan->kode_kendaraan,

                // gunakan nama_kendaraan atau merk sesuai tabel Anda
                'nama' => $driver->kendaraan->merk ?? $driver->kendaraan->nama_kendaraan,

                'nomor_polisi' => $driver->kendaraan->nomor_polisi,

                'kapasitas' => $driver->kendaraan->kapasitas,

            ],

            'jumlah_tps' => $driver->tps->count(),

            'tps' => $driver->tps->map(function ($tps) {

                return [

                    'id' => $tps->id,

                    'kode_tps' => $tps->kode_tps,

                    'nama_tps' => $tps->nama_tps,

                    'alamat' => $tps->alamat,

                    'latitude' => $tps->latitude,

                    'longitude' => $tps->longitude,

                ];

            })

        ]);
    }

        public function store(Request $request)
{
    $request->validate([
        'tanggal'  => 'required|date',
        'driver_id'=> 'required|exists:drivers,id',
        'pool_id'  => 'required|exists:pools,id',
        'tpa_id'   => 'required|exists:tpas,id',
    ]);

    $driver = Driver::with([
        'kendaraan',
        'tps'
    ])->findOrFail($request->driver_id);

    if (!$driver->kendaraan) {

        return back()
            ->withInput()
            ->withErrors([
                'driver_id' => 'Driver belum memiliki kendaraan.'
            ]);

    }

    if ($driver->tps->count() == 0) {

        return back()
            ->withInput()
            ->withErrors([
                'driver_id' => 'Driver belum memiliki wilayah TPS.'
            ]);

    }

    $pool = Pool::findOrFail($request->pool_id);

    $tpa = Tpa::findOrFail($request->tpa_id);

    $pengangkutan = null;

    DB::transaction(function () use (
        $request,
        $driver,
        $pool,
        $tpa,
        &$pengangkutan
    ) {

        $last = Pengangkutan::latest()->first();

        $nomor = $last
            ? ((int) substr($last->kode_pengangkutan, 3)) + 1
            : 1;

        $kode = 'PNG' . str_pad(
            $nomor,
            3,
            '0',
            STR_PAD_LEFT
        );

        /*
        |------------------------------------------------------
        | Generate Nearest Neighbor
        |------------------------------------------------------
        */

        $hasil = $this->nearestNeighbor->generate(

            $driver,

            $pool,

            $tpa

        );

        /*
        |------------------------------------------------------
        | Simpan Pengangkutan
        |------------------------------------------------------
        */

        $pengangkutan = Pengangkutan::create([

            'kode_pengangkutan' => $kode,

            'tanggal' => $request->tanggal,

            'driver_id' => $driver->id,

            'kendaraan_id' => $driver->kendaraan->id,

            'pool_id' => $pool->id,

            'tpa_id' => $tpa->id,

            'total_jarak' => $hasil['total_jarak'],

            'estimasi_waktu' => $hasil['estimasi_waktu'],

            'status' => 'Belum Berangkat',

        ]);

        /*
        |------------------------------------------------------
        | Simpan Detail TPS
        |------------------------------------------------------
        */

        foreach ($hasil['rute'] as $item) {

            PengangkutanTps::create([

                'pengangkutan_id' => $pengangkutan->id,

                'tps_id' => $item['tps']->id,

                'urutan' => $item['urutan'],

                'jarak' => $item['jarak'],

                'estimasi_waktu' => round(
                    $item['jarak'] * 3
                ),

                'volume_diangkut' => 0,

                'status' => 'Belum',

            ]);

        }

    });

    return redirect()
        ->route(
            'admin.pengangkutan.show',
            $pengangkutan
        )
        ->with(
            'success',
            'Optimasi rute berhasil dibuat.'
        );
}
    


    /**
 * ==========================================================
 * Detail Pengangkutan
 * ==========================================================
 */
public function show(Pengangkutan $pengangkutan)
{
    $pengangkutan->load([

        'driver',

        'kendaraan',

        'pool',

        'tpa',

        'detailTps.tps',

    ]);

    return view(
        'admin.pengangkutan.show',
        compact('pengangkutan')
    );
}

/**
 * ==========================================================
 * Hapus Pengangkutan
 * ==========================================================
 */
public function destroy(Pengangkutan $pengangkutan)
{
    DB::transaction(function () use ($pengangkutan) {

        $pengangkutan->detailTps()->delete();

        $pengangkutan->delete();

    });

    return redirect()
        ->route('admin.pengangkutan.index')
        ->with(
            'success',
            'Data pengangkutan berhasil dihapus.'
        );
}

/**
 * ==========================================================
 * Edit
 * ==========================================================
 */
public function edit(Pengangkutan $pengangkutan)
{
    abort(404);
}

/**
 * ==========================================================
 * Update
 * ==========================================================
 */
public function update(
    Request $request,
    Pengangkutan $pengangkutan
){
    abort(404);
}}