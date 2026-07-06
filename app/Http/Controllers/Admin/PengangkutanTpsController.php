<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengangkutan;
use App\Models\PengangkutanTps;
use Illuminate\Http\Request;

class PengangkutanTpsController extends Controller
{
    public function store(Request $request, Pengangkutan $pengangkutan)
    {
        $request->validate([

            'tps_id'=>'required|exists:tps,id',

            'berat_sampah'=>'required|numeric|min:0'

        ]);

        $urutan=$pengangkutan
                ->detailPengangkutan()
                ->count()+1;

                if (
    $pengangkutan->detailPengangkutan()
        ->where('tps_id', $request->tps_id)
        ->exists()
) {
    return back()->withErrors([
        'tps_id' => 'TPS sudah ditambahkan pada pengangkutan ini.'
    ]);
}

        PengangkutanTps::create([

            'pengangkutan_id'=>$pengangkutan->id,

            'tps_id'=>$request->tps_id,

            'urutan'=>$urutan,

            'jarak'=>0,

            'berat_sampah'=>$request->berat_sampah

        ]);

        return back()->with(
            'success',
            'TPS berhasil ditambahkan.'
        );
    }

    public function destroy(PengangkutanTps $detail)
    {
        $detail->delete();

        return back()->with(
            'success',
            'TPS berhasil dihapus.'
        );
    }
}