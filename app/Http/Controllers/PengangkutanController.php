<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Kendaraan;
use App\Models\Pengangkutan;
use App\Models\Pool;
use App\Models\Tpa;
use Illuminate\Http\Request;

class PengangkutanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $pengangkutans = Pengangkutan::with([
            'driver',
            'kendaraan',
            'pool',
            'tpa'
        ])

        ->when($search,function($query) use($search){

            $query->where('kode_pengangkutan','like',"%{$search}%");

        })

        ->latest()

        ->paginate(10)

        ->withQueryString();

        return view('admin.pengangkutan.index',compact(
            'pengangkutans',
            'search'
        ));
    }

    public function create()
    {
        $drivers = Driver::where('status','Aktif')->get();

        $kendaraans = Kendaraan::where('status','Aktif')->get();

        $pools = Pool::where('status','Aktif')->get();

        $tpas = Tpa::where('status','Aktif')->get();

        return view('admin.pengangkutan.create',compact(
            'drivers',
            'kendaraans',
            'pools',
            'tpas'
        ));
    }

    public function store(Request $request)
    {

    }

    public function show(Pengangkutan $pengangkutan)
    {
        return view('admin.pengangkutan.show',compact('pengangkutan'));
    }

    public function edit(Pengangkutan $pengangkutan)
    {
        return view('admin.pengangkutan.edit',compact('pengangkutan'));
    }

    public function update(Request $request,Pengangkutan $pengangkutan)
    {

    }

    public function destroy(Pengangkutan $pengangkutan)
    {

    }
}