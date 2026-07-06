@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Driver</h1>
        <p class="text-gray-500">Selamat datang, <span class="font-semibold text-gray-800">{{ $driver->nama }}</span></p>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Card Kendaraan --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Kendaraan</p>
            <h2 class="text-lg font-bold mt-1 text-gray-800">{{ $kendaraan->nama_kendaraan ?? '-' }}</h2>
            <p class="text-sm text-blue-600 font-medium">{{ $kendaraan->nomor_polisi ?? '-' }}</p>
        </div>

        {{-- Card TPS Hari Ini --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">TPS Hari Ini</p>
            <h2 class="text-3xl font-bold mt-1 text-gray-800">{{ $totalTPS }}</h2>
            <p class="text-sm text-gray-400">Total lokasi</p>
        </div>

        {{-- Card TPS Selesai --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">TPS Selesai</p>
            <h2 class="text-3xl font-bold mt-1 text-green-600">{{ $tpsSelesai }}</h2>
            <p class="text-sm text-gray-400">Telah diangkut</p>
        </div>

        {{-- Card Muatan --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Total Muatan</p>
            <h2 class="text-3xl font-bold mt-1 text-blue-600">{{ number_format($muatan) }}</h2>
            <p class="text-sm text-gray-400">Kilogram (Kg)</p>
        </div>
    </div>

    {{-- Pengangkutan Hari Ini --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="border-b border-gray-100 px-6 py-4 flex justify-between items-center bg-gray-50">
            <h2 class="font-bold text-gray-800">Status Pengangkutan Hari Ini</h2>
            @if($pengangkutan)
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase 
                    {{ $pengangkutan->status == 'Selesai' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ $pengangkutan->status }}
                </span>
            @endif
        </div>

        <div class="p-6">
            @if($pengangkutan)
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold">Tanggal</p>
                        <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($pengangkutan->tanggal)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold">Pool</p>
                        <p class="font-semibold text-gray-800">{{ $pengangkutan->optimasi->pool->nama_pool }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold">TPA</p>
                        <p class="font-semibold text-gray-800">{{ $pengangkutan->optimasi->tpa->nama_tpa }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold">Status Perjalanan</p>
                        <p class="font-semibold text-blue-600">{{ $pengangkutan->status_perjalanan }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold">Kapasitas Truk</p>
                        <p class="font-semibold text-gray-800">{{ number_format($pengangkutan->kapasitas_kendaraan) }} Kg</p>
                    </div>
                </div>
            @else
                <div class="text-center py-10 text-gray-400">
                    <p>Tidak ada jadwal pengangkutan untuk hari ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection