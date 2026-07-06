<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pool;
use Illuminate\Http\Request;

class PoolController extends Controller
{
    /**
     * Menampilkan daftar Pool
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $pools = Pool::when($search, function ($query) use ($search) {
                $query->where('nama_pool', 'like', "%{$search}%")
                      ->orWhere('kode_pool', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pool.index', compact('pools', 'search'));
    }

    /**
     * Form tambah Pool
     */
    public function create()
    {
        return view('admin.pool.create');
    }

    /**
     * Simpan Pool
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pool' => 'required|max:100',
            'alamat' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        // Generate Kode Pool
        $lastPool = Pool::latest()->first();

        if ($lastPool) {
            $nomor = (int) substr($lastPool->kode_pool, 3) + 1;
        } else {
            $nomor = 1;
        }

        $kodePool = 'POL' . str_pad($nomor, 3, '0', STR_PAD_LEFT);

        Pool::create([
            'kode_pool' => $kodePool,
            'nama_pool' => $request->nama_pool,
            'alamat' => $request->alamat,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.pool.index')
            ->with('success', 'Data Pool berhasil ditambahkan.');
    }

    /**
     * Detail Pool
     */
    public function show(Pool $pool)
    {
        return view('admin.pool.show', compact('pool'));
    }

    /**
     * Form Edit Pool
     */
    public function edit(Pool $pool)
    {
        return view('admin.pool.edit', compact('pool'));
    }

    /**
     * Update Pool
     */
    public function update(Request $request, Pool $pool)
    {
        $request->validate([
            'nama_pool' => 'required|max:100',
            'alamat' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $pool->update([
            'nama_pool' => $request->nama_pool,
            'alamat' => $request->alamat,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.pool.index')
            ->with('success', 'Data Pool berhasil diperbarui.');
    }

    /**
     * Hapus Pool
     */
    public function destroy(Pool $pool)
    {
        $pool->delete();

        return redirect()
            ->route('admin.pool.index')
            ->with('success', 'Data Pool berhasil dihapus.');
    }
}