<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KendaraanController extends Controller
{
    /**
     * ==========================================================
     * Daftar Kendaraan
     * ==========================================================
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $kendaraans = Kendaraan::with('driver')

            ->when($search, function ($query) use ($search) {

                $query->where(
                    'kode_kendaraan',
                    'like',
                    "%{$search}%"
                )

                    ->orWhere(
                        'nama_kendaraan',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'nomor_polisi',
                        'like',
                        "%{$search}%"
                    );
            })

            ->latest()

            ->paginate(10)

            ->withQueryString();

        return view(
            'admin.kendaraan.index',
            compact(
                'kendaraans',
                'search'
            )
        );
    }

    /**
     * ==========================================================
     * Form Tambah Kendaraan
     * ==========================================================
     */
    public function create()
    {
        /*
        |--------------------------------------------------------------------------
        | Driver aktif yang belum memiliki kendaraan
        |--------------------------------------------------------------------------
        */

        $drivers = Driver::where(
            'status',
            'Aktif'
        )

            ->whereDoesntHave('kendaraan')

            ->orderBy('nama')

            ->get();

        return view(
            'admin.kendaraan.create',
            compact(
                'drivers'
            )
        );
    }

    /**
     * ==========================================================
     * Simpan Kendaraan
     * ==========================================================
     */
    public function store(Request $request)
    {
        $request->validate([

            'driver_id' => [
                'required',
                'exists:drivers,id',
                'unique:kendaraans,driver_id'
            ],

            'nama_kendaraan' => [
                'required',
                'string',
                'max:100'
            ],

            'nomor_polisi' => [
                'required',
                'string',
                'max:20',
                'unique:kendaraans,nomor_polisi'
            ],

            'kapasitas' => [
                'required',
                'numeric',
                'min:1'
            ],

            'status' => [
                'required',
                'in:Aktif,Tidak Aktif,Perawatan'
            ],

        ]);

     /*
|--------------------------------------------------------------------------
| Generate Kode Kendaraan
|--------------------------------------------------------------------------
*/

        $existingKodes = Kendaraan::pluck('kode_kendaraan')->map(fn($k) => trim($k))->toArray();
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
            $kode = 'KDR' . str_pad($nomor, 3, '0', STR_PAD_LEFT);
            $nomor++;
        } while (
            in_array($kode, $existingKodes) ||
            Kendaraan::where('kode_kendaraan', $kode)->orWhere('kode_kendaraan', 'like', $kode . '%')->exists()
        );
        /*
        |--------------------------------------------------------------------------
        | Simpan Data
        |--------------------------------------------------------------------------
        */

     DB::transaction(function () use ($request, $kode) {

    Kendaraan::create([

        'driver_id'       => $request->driver_id,

        'kode_kendaraan'  => $kode,

        'nama_kendaraan'  => $request->nama_kendaraan,

        'nomor_polisi'    => strtoupper($request->nomor_polisi),

        'kapasitas'       => $request->kapasitas,

        'status'          => $request->status,

    ]);

});

        return redirect()
            ->route('admin.kendaraan.index')
            ->with(
                'success',
                'Data kendaraan berhasil ditambahkan.'
            );
    }

    /**
     * ==========================================================
     * Detail Kendaraan
     * ==========================================================
     */
    public function show(Kendaraan $kendaraan)
    {
        $kendaraan->load('driver');

        return view(
            'admin.kendaraan.show',
            compact('kendaraan')
        );
    }

    /**
     * ==========================================================
     * Form Edit Kendaraan
     * ==========================================================
     */
    public function edit(Kendaraan $kendaraan)
    {
        /*
        |--------------------------------------------------------------------------
        | Driver aktif yang belum memiliki kendaraan
        | atau driver yang sedang menggunakan kendaraan ini
        |--------------------------------------------------------------------------
        */

        $drivers = Driver::where(
            'status',
            'Aktif'
        )

            ->where(function ($query) use ($kendaraan) {

                $query->whereDoesntHave('kendaraan')

                    ->orWhere(
                        'id',
                        $kendaraan->driver_id
                    );
            })

            ->orderBy('nama')

            ->get();

        return view(
            'admin.kendaraan.edit',
            compact(
                'kendaraan',
                'drivers'
            )
        );
    }

    /**
     * ==========================================================
     * Update Kendaraan
     * ==========================================================
     */
    public function update(
        Request $request,
        Kendaraan $kendaraan
    ) {

        $request->validate([

            'driver_id' => [
                'required',
                'exists:drivers,id',
                'unique:kendaraans,driver_id,' . $kendaraan->id
            ],

            'nama_kendaraan' => [
                'required',
                'string',
                'max:100'
            ],

            'nomor_polisi' => [
                'required',
                'string',
                'max:20',
                'unique:kendaraans,nomor_polisi,' . $kendaraan->id
            ],

            'kapasitas' => [
                'required',
                'numeric',
                'min:1'
            ],

            'status' => [
                'required',
                'in:Aktif,Tidak Aktif,Perawatan'
            ],

        ]);

        $kendaraan->update([

            'driver_id' => $request->driver_id,

            'nama_kendaraan' => $request->nama_kendaraan,

            'nomor_polisi' => strtoupper(
                $request->nomor_polisi
            ),

            'kapasitas' => $request->kapasitas,

            'status' => $request->status,

        ]);

        return redirect()
            ->route('admin.kendaraan.index')
            ->with(
                'success',
                'Data kendaraan berhasil diperbarui.'
            );
    }

    /**
     * ==========================================================
     * Hapus Kendaraan
     * ==========================================================
     */
    public function destroy(Kendaraan $kendaraan)
    {
        /*
        |--------------------------------------------------------------------------
        | Cegah menghapus kendaraan yang pernah digunakan
        |--------------------------------------------------------------------------
        */

        if ($kendaraan->optimasiRutes()->exists()) {

            return redirect()
                ->route('admin.kendaraan.index')
                ->with(
                    'warning',
                    'Kendaraan sudah digunakan pada data optimasi dan tidak dapat dihapus.'
                );
        }

        $kendaraan->delete();

        return redirect()
            ->route('admin.kendaraan.index')
            ->with(
                'success',
                'Data kendaraan berhasil dihapus.'
            );
    }
}
