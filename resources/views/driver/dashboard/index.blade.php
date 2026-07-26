@extends('layouts.app')

@section('title', 'Dashboard Driver - SIMPAS DLH')

@section('content')
<div class="space-y-6">

    {{-- Hero Header Card --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Dashboard Driver</h1>
                <span class="px-2.5 py-0.5 text-xs font-semibold text-green-700 bg-green-50 border border-green-200 rounded-full">
                    <i class="fas fa-truck-fast text-[10px] mr-1"></i> Driver SIMPAS
                </span>
            </div>
            <p class="text-gray-500 text-sm mt-1">Selamat bertugas, <span class="font-semibold text-gray-700">{{ $driver->nama ?? auth()->user()->name }}</span>! Pantau rute dan tugas pengangkutan Anda.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('driver.rute.index') }}" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium text-sm px-4 py-2 rounded-lg transition shadow-sm">
                <i class="fas fa-route"></i>
                <span>Lihat Rute Penugasan Saya</span>
            </a>
        </div>
    </div>

    {{-- SECTION 1: STATUS ARMADA & UTAMA DRIVER --}}
    <div class="space-y-3">
        <div class="border-l-4 border-green-600 pl-3">
            <h2 class="text-base font-bold text-gray-800">Status Armada & Informasi Driver</h2>
            <p class="text-xs text-gray-500">Informasi unit kendaraan dan profil operasional Anda</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            {{-- Card Kendaraan --}}
            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Unit Kendaraan</p>
                    <h3 class="text-lg font-bold text-gray-800 mt-1">{{ $kendaraan->nama_kendaraan ?? 'Belum Ditugaskan' }}</h3>
                    <p class="text-xs font-semibold text-green-600 mt-0.5">{{ $kendaraan->nomor_polisi ?? 'No. Polisi -' }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-xl">
                    <i class="fas fa-truck"></i>
                </div>
            </div>

            {{-- Card Kode Driver --}}
            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Identitas Driver</p>
                    <h3 class="text-lg font-bold text-gray-800 mt-1">{{ $driver->kode_driver ?? '-' }}</h3>
                    <p class="text-xs font-semibold text-blue-600 mt-0.5">{{ $driver->no_hp ?? 'No. HP -' }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    <i class="fas fa-id-badge"></i>
                </div>
            </div>

            {{-- Card Kapasitas Truk --}}
            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Kapasitas Maksimal</p>
                    <h3 class="text-lg font-bold text-gray-800 mt-1">{{ number_format($kendaraan->kapasitas ?? 0) }} <span class="text-xs font-normal text-gray-500">Kg</span></h3>
                    <p class="text-xs font-semibold text-gray-400 mt-0.5">Daya angkut kendaraan</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-xl">
                    <i class="fas fa-weight-hanging"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- PEMBATAS SECTION --}}
    <div class="relative flex py-2 items-center">
        <div class="flex-grow border-t border-gray-200"></div>
        <span class="flex-shrink mx-4 text-xs font-bold text-gray-500 uppercase tracking-wider px-3 py-1 bg-gray-100 rounded-full border border-gray-200">
            <i class="fas fa-tasks text-green-600 mr-1.5"></i> Stat Penugasan Lapangan Hari Ini
        </span>
        <div class="flex-grow border-t border-gray-200"></div>
    </div>

    {{-- SECTION 2: STAT PENUGASAN LAPANGAN HARI INI --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Card TPS Hari Ini --}}
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Target TPS Hari Ini</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalTPS }}</h3>
                <p class="text-[11px] text-gray-400 mt-1 font-medium">Titik penampungan rute</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-yellow-50 text-yellow-600 flex items-center justify-center text-xl">
                <i class="fas fa-dumpster"></i>
            </div>
        </div>

        {{-- Card TPS Selesai --}}
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">TPS Selesai Diangkut</p>
                <h3 class="text-2xl font-bold text-green-600 mt-1">{{ $tpsSelesai }}</h3>
                <p class="text-[11px] text-green-600 mt-1 font-medium">Sudah dibersihkan</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-xl">
                <i class="fas fa-circle-check"></i>
            </div>
        </div>

        {{-- Card Sisa TPS --}}
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Sisa TPS Belum</p>
                <h3 class="text-2xl font-bold text-cyan-600 mt-1">{{ max(0, $totalTPS - $tpsSelesai) }}</h3>
                <p class="text-[11px] text-gray-400 mt-1 font-medium">Menunggu pengangkutan</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-xl">
                <i class="fas fa-clock"></i>
            </div>
        </div>

        {{-- Card Muatan --}}
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Muatan Sampah</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-1">{{ number_format($muatan) }} <span class="text-sm font-normal">Kg</span></h3>
                <p class="text-[11px] text-gray-400 mt-1 font-medium">Volume di dalam truk</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="fas fa-scale-balanced"></i>
            </div>
        </div>
    </div>

    {{-- SECTION 3: STATUS PENGANGKUTAN AKTIF --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="border-b border-gray-100 px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center text-sm">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h2 class="font-bold text-gray-800">Status Penugasan Pengangkutan Hari Ini</h2>
            </div>
            @if($pengangkutan)
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                    {{ $pengangkutan->status == 'Selesai' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    <i class="fas {{ $pengangkutan->status == 'Selesai' ? 'fa-check-circle' : 'fa-spinner fa-spin' }} text-[10px]"></i>
                    {{ $pengangkutan->status }}
                </span>
            @endif
        </div>

        <div class="p-6">
            @if($pengangkutan)
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">Tanggal</p>
                        <p class="font-semibold text-gray-800 mt-1">{{ \Carbon\Carbon::parse($pengangkutan->tanggal)->format('d M Y') }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">Pool Keberangkatan</p>
                        <p class="font-semibold text-gray-800 mt-1">{{ $pengangkutan->optimasi->pool->nama_pool ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">TPA Tujuan</p>
                        <p class="font-semibold text-gray-800 mt-1">{{ $pengangkutan->optimasi->tpa->nama_tpa ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">Status Perjalanan</p>
                        <p class="font-semibold text-green-600 mt-1">{{ $pengangkutan->status_perjalanan ?? 'Di Pool' }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">Kapasitas Truk</p>
                        <p class="font-semibold text-gray-800 mt-1">{{ number_format($pengangkutan->kapasitas_kendaraan) }} Kg</p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('driver.pengangkutan.index') }}" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium text-sm px-5 py-2 rounded-lg shadow-sm transition">
                        <span>Buka Menu Pengangkutan</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-10 text-gray-400">
                    <div class="w-12 h-12 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mx-auto mb-3 text-lg">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <p class="font-medium">Tidak ada tugas pengangkutan untuk hari ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection