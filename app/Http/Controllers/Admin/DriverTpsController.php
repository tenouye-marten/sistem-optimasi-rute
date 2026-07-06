<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Tps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverTpsController extends Controller
{
    /**
     * Daftar Wilayah Driver
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $drivers = Driver::withCount('tps')
            ->when($request->filled('search'), function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('kode_driver', 'like', "%{$search}%");
            })
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('admin.driver-tps.index', compact(
            'drivers',
            'search'
        ));
    }

    /**
     * Detail Wilayah Driver
     */
    public function show(Driver $driver)
{
    $driver->load('tps');

    $totalKapasitas = $driver->tps->sum('kapasitas');

    return view(
        'admin.driver-tps.show',
        compact(
            'driver',
            'totalKapasitas'
        )
    );
}

    /**
     * Form Kelola Wilayah Driver
     */
    public function edit(Driver $driver)
    {
        $driver->load('tps');

        $tps = Tps::with('drivers')
            ->where('status', 'Aktif')
            ->orderBy('nama_tps')
            ->get();

        return view(
            'admin.driver-tps.edit',
            compact(
                'driver',
                'tps'
            )
        );
    }

    /**
     * Simpan Wilayah Driver
     */
    public function update(Request $request, Driver $driver)
    {
        $request->validate([
            'tps'   => 'required|array|min:1',
            'tps.*' => 'exists:tps,id',
        ]);

        foreach ($request->tps as $tpsId) {

            $digunakanDriverLain = DB::table('driver_tps')
                ->where('tps_id', $tpsId)
                ->where('driver_id', '!=', $driver->id)
                ->exists();

            if ($digunakanDriverLain) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'tps' => 'Salah satu TPS sudah menjadi wilayah driver lain.'
                    ]);
            }
        }

        $driver->tps()->sync($request->tps);

        return redirect()
            ->route('admin.driver-tps.index')
            ->with(
                'success',
                'Wilayah driver berhasil diperbarui.'
            );
    }
}