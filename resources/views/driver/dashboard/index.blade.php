@extends('layouts.app')

@section('title', 'Dashboard Driver - SIMPAS DLH')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Dashboard Driver</h1>
                <span class="px-2.5 py-0.5 text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200/80 rounded-full">Driver SIMPAS</span>
            </div>
            <p class="text-slate-500 text-sm mt-1">Selamat bertugas, <span class="font-semibold text-slate-700">{{ $driver->nama ?? auth()->user()->name }}</span>!</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('driver.rute.index') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm px-4 py-2.5 rounded-xl shadow-xs transition-all hover:shadow-sm">
                <i class="fas fa-route"></i>
                <span>Lihat Rute Saya</span>
            </a>
        </div>
    </div>

    {{-- Driver Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Card Kendaraan --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kendaraan</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center">
                    <i class="fas fa-truck text-base"></i>
                </div>
            </div>
            <div class="mt-3">
                <h2 class="text-lg font-bold text-slate-800">{{ $kendaraan->nama_kendaraan ?? '-' }}</h2>
                <p class="text-xs font-semibold text-emerald-600 mt-0.5">{{ $kendaraan->nomor_polisi ?? 'Belum ada unit' }}</p>
            </div>
        </div>

        {{-- Card TPS Hari Ini --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">TPS Hari Ini</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center">
                    <i class="fas fa-dumpster text-base"></i>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-bold text-slate-800 tracking-tight">{{ $totalTPS }}</span>
                <p class="text-xs text-slate-400 font-medium">Total titik TPS</p>
            </div>
        </div>

        {{-- Card TPS Selesai --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">TPS Selesai</span>
                <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 border border-teal-100 flex items-center justify-center">
                    <i class="fas fa-circle-check text-base"></i>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-bold text-teal-600 tracking-tight">{{ $tpsSelesai }}</span>
                <p class="text-xs text-slate-400 font-medium">Telah diangkut</p>
            </div>
        </div>

        {{-- Card Muatan --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Muatan</span>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center">
                    <i class="fas fa-scale-balanced text-base"></i>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-bold text-blue-600 tracking-tight">{{ number_format($muatan) }}</span>
                <p class="text-xs text-slate-400 font-medium">Kilogram (Kg)</p>
            </div>
        </div>
    </div>

    {{-- Pengangkutan Hari Ini --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="border-b border-slate-100 px-6 py-4 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h2 class="font-bold text-slate-800">Status Pengangkutan Hari Ini</h2>
            </div>
            @if($pengangkutan)
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                    {{ $pengangkutan->status == 'Selesai' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                    <i class="fas {{ $pengangkutan->status == 'Selesai' ? 'fa-check-circle' : 'fa-spinner fa-spin' }} text-[10px]"></i>
                    {{ $pengangkutan->status }}
                </span>
            @endif
        </div>

        <div class="p-6">
            @if($pengangkutan)
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Tanggal</p>
                        <p class="font-semibold text-slate-800 mt-1">{{ \Carbon\Carbon::parse($pengangkutan->tanggal)->format('d M Y') }}</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Pool Keberangkatan</p>
                        <p class="font-semibold text-slate-800 mt-1">{{ $pengangkutan->optimasi->pool->nama_pool ?? '-' }}</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">TPA Tujuan</p>
                        <p class="font-semibold text-slate-800 mt-1">{{ $pengangkutan->optimasi->tpa->nama_tpa ?? '-' }}</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Status Perjalanan</p>
                        <p class="font-semibold text-emerald-600 mt-1">{{ $pengangkutan->status_perjalanan ?? 'Di Pool' }}</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Kapasitas Truk</p>
                        <p class="font-semibold text-slate-800 mt-1">{{ number_format($pengangkutan->kapasitas_kendaraan) }} Kg</p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('driver.pengangkutan.index') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm px-5 py-2.5 rounded-xl shadow-xs transition-all">
                        <span>Buka Menu Pengangkutan</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-10 text-slate-400">
                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3 text-lg">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <p class="font-medium">Tidak ada tugas pengangkutan untuk hari ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection