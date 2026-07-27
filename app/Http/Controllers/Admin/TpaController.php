<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tpa;
use Illuminate\Http\Request;

class TpaController extends Controller
{
    /**
     * ==========================================================
     * Daftar TPA
     * ==========================================================
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $tpas = Tpa::when($search, function ($query) use ($search) {

                $query->where('nama_tpa', 'like', "%{$search}%")
                      ->orWhere('kode_tpa', 'like', "%{$search}%");

            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.tpa.index',
            compact(
                'tpas',
                'search'
            )
        );
    }

    /**
     * ==========================================================
     * Form Tambah TPA
     * ==========================================================
     */
    public function create()
    {
        return view('admin.tpa.create');
    }

    /**
     * ==========================================================
     * Simpan TPA
     * ==========================================================
     */
    public function store(Request $request)
    {
        $request->validate([

            'nama_tpa' => 'required|string|max:100',

            'alamat' => 'required|string',

            'latitude' => 'required|numeric',

            'longitude' => 'required|numeric',

            'status' => 'required|in:Aktif,Tidak Aktif',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Generate Kode TPA
        |--------------------------------------------------------------------------
        */

        $existingKodes = Tpa::pluck('kode_tpa')->map(fn($k) => trim($k))->toArray();
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
            $kode = 'TPA' . str_pad($nomor, 3, '0', STR_PAD_LEFT);
            $nomor++;
        } while (
            in_array($kode, $existingKodes) ||
            Tpa::where('kode_tpa', $kode)->orWhere('kode_tpa', 'like', $kode . '%')->exists()
        );

        /*
        |--------------------------------------------------------------------------
        | Simpan Data
        |--------------------------------------------------------------------------
        */

        Tpa::create([

            'kode_tpa' => $kode,

            'nama_tpa' => $request->nama_tpa,

            'alamat' => $request->alamat,

            'latitude' => $request->latitude,

            'longitude' => $request->longitude,

            'status' => $request->status,

        ]);

        return redirect()
            ->route('admin.tpa.index')
            ->with(
                'success',
                'Data TPA berhasil ditambahkan.'
            );
    }

    /**
     * ==========================================================
     * Detail TPA
     * ==========================================================
     */
    public function show(Tpa $tpa)
    {
        return view(
            'admin.tpa.show',
            compact('tpa')
        );
    }

    /**
     * ==========================================================
     * Form Edit TPA
     * ==========================================================
     */
    public function edit(Tpa $tpa)
    {
        return view(
            'admin.tpa.edit',
            compact('tpa')
        );
    }

    /**
     * ==========================================================
     * Update TPA
     * ==========================================================
     */
    public function update(
        Request $request,
        Tpa $tpa
    ) {
        $request->validate([

            'nama_tpa' => 'required|string|max:100',

            'alamat' => 'required|string',

            'latitude' => 'required|numeric',

            'longitude' => 'required|numeric',

            'status' => 'required|in:Aktif,Tidak Aktif',

        ]);

        $tpa->update([

            'nama_tpa' => $request->nama_tpa,

            'alamat' => $request->alamat,

            'latitude' => $request->latitude,

            'longitude' => $request->longitude,

            'status' => $request->status,

        ]);

        return redirect()
            ->route('admin.tpa.index')
            ->with(
                'success',
                'Data TPA berhasil diperbarui.'
            );
    }

    /**
     * ==========================================================
     * Hapus TPA
     * ==========================================================
     */
    public function destroy(Tpa $tpa)
    {
        $tpa->delete();

        return redirect()
            ->route('admin.tpa.index')
            ->with(
                'success',
                'Data TPA berhasil dihapus.'
            );
    }
}