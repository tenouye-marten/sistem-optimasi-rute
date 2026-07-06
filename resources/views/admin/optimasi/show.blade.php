@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Hasil Optimasi</h1>
            <p class="text-sm text-gray-500">Hasil optimasi rute menggunakan metode Nearest Neighbor.</p>
        </div>
        <a href="{{ route('admin.optimasi.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg text-sm transition">
            Kembali
        </a>
    </div>

    {{-- Info Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-blue-600 text-white rounded-xl p-6 shadow-sm">
            <p class="text-blue-100 text-sm">Jumlah TPS</p>
            <h1 class="text-3xl font-bold mt-1">{{ $optimasi->jumlah_tps }}</h1>
        </div>
        <div class="bg-green-600 text-white rounded-xl p-6 shadow-sm">
            <p class="text-green-100 text-sm">Total Jarak</p>
            <h1 class="text-3xl font-bold mt-1">{{ number_format($optimasi->total_jarak, 2) }} <span class="text-lg font-normal">Km</span></h1>
        </div>
        <div class="bg-red-600 text-white rounded-xl p-6 shadow-sm">
            <p class="text-red-100 text-sm">Estimasi Waktu</p>
            <h1 class="text-3xl font-bold mt-1">{{ $optimasi->estimasi_waktu }} <span class="text-lg font-normal">Menit</span></h1>
        </div>
    </div>

    {{-- Informasi Optimasi --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informasi Umum</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 text-sm">
            @php
                $info = [
                    'Kode Optimasi'    => $optimasi->kode_optimasi,
                    'Tanggal Generate' => $optimasi->tanggal_generate,
                    'Driver'           => $optimasi->driver->nama,
                    'Kendaraan'        => $optimasi->kendaraan->nama_kendaraan ?? '-',
                    'Pool'             => $optimasi->pool->nama_pool,
                    'TPA'              => $optimasi->tpa->nama_tpa,
                ];
            @endphp
            @foreach($info as $label => $value)
                <div class="flex flex-col">
                    <span class="text-gray-500 font-medium">{{ $label }}</span>
                    <span class="font-semibold text-gray-900 mt-0.5">{{ $value }}</span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Urutan Rute --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-6">Urutan Rute Optimasi</h2>
        <div class="flex flex-wrap items-center gap-2">
            <div class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">POOL</div>
            @foreach($optimasi->details as $detail)
                <span class="text-gray-400">→</span>
                <div class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">{{ $detail->tps->nama_tps }}</div>
            @endforeach
            <span class="text-gray-400">→</span>
            <div class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">TPA</div>
        </div>
    </div>

    {{-- Detail Tabel --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800">Detail Hasil Optimasi</h2>
        </div>
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3 text-center w-16">No</th>
                    <th class="px-6 py-3">Nama TPS</th>
                    <th class="px-6 py-3 text-center">Jarak (Km)</th>
                    <th class="px-6 py-3 text-center">Estimasi (Menit)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($optimasi->details as $detail)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-center">{{ $detail->urutan }}</td>
                    <td class="px-6 py-3 font-medium text-gray-900">{{ $detail->tps->nama_tps }}</td>
                    <td class="px-6 py-3 text-center font-mono">{{ number_format($detail->jarak, 2) }}</td>
                    <td class="px-6 py-3 text-center">{{ $detail->estimasi_waktu }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection