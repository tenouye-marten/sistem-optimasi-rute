<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tps;
use Illuminate\Http\Request;

class TpsController extends Controller
{

public function index(Request $request)
{
    $search = $request->search;

    $tps = Tps::when($search, function ($query) use ($search) {

        $query->where('nama_tps', 'like', "%{$search}%")
              ->orWhere('kode_tps', 'like', "%{$search}%");

    })

    ->latest()

    ->paginate(10)

    ->withQueryString();

    return view('admin.tps.index', compact(
        'tps',
        'search'
    ));
}


    public function create()
    {
        return view('admin.tps.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_tps'   => 'required|max:100',
        'alamat'     => 'required',
        'latitude'   => 'required|numeric',
        'longitude'  => 'required|numeric',
        'kapasitas'  => 'required|integer|min:1',
        'status'     => 'required|in:Aktif,Tidak Aktif',
    ]);

    $existingKodes = Tps::pluck('kode_tps')->map(fn($k) => trim($k))->toArray();
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
        $kode = 'TPS' . str_pad($nomor, 3, '0', STR_PAD_LEFT);
        $nomor++;
    } while (
        in_array($kode, $existingKodes) ||
        Tps::where('kode_tps', $kode)->orWhere('kode_tps', 'like', $kode . '%')->exists()
    );

    Tps::create([

        'kode_tps'  => $kode,

        'nama_tps'  => $request->nama_tps,

        'alamat'    => $request->alamat,

        'latitude'  => $request->latitude,

        'longitude' => $request->longitude,

        'kapasitas' => $request->kapasitas,

        'status'    => $request->status,

    ]);

    return redirect()
            ->route('admin.tps.index')
            ->with('success','Data TPS berhasil ditambahkan.');
}

    public function show(Tps $tp)
    {
        return view('admin.tps.show',compact('tp'));
    }

  public function edit(Tps $tp)
{
    return view('admin.tps.edit', compact('tp'));
}

public function update(Request $request, Tps $tp)
{
    $request->validate([
        'nama_tps'   => 'required|max:100',
        'alamat'     => 'required',
        'latitude'   => 'required|numeric',
        'longitude'  => 'required|numeric',
        'kapasitas'  => 'required|integer|min:1',
        'status'     => 'required|in:Aktif,Tidak Aktif',
    ]);

    $tp->update([

        'nama_tps'  => $request->nama_tps,

        'alamat'    => $request->alamat,

        'latitude'  => $request->latitude,

        'longitude' => $request->longitude,

        'kapasitas' => $request->kapasitas,

        'status'    => $request->status,

    ]);

    return redirect()
            ->route('admin.tps.index')
            ->with('success','Data TPS berhasil diperbarui.');
}

  public function destroy(Tps $tp)
{
    $tp->delete();

    return redirect()
            ->route('admin.tps.index')
            ->with('success', 'Data TPS berhasil dihapus.');
}
}