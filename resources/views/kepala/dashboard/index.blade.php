@extends('layouts.app')

@section('title', 'Dashboard Kepala Dinas - SIMPAS DLH')

@section('content')
<div class="space-y-6">

    {{-- Hero Header Card --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Dashboard Eksekutif</h1>
                <span class="px-2.5 py-0.5 text-xs font-semibold text-green-700 bg-green-50 border border-green-200 rounded-full">
                    <i class="fas fa-user-tie text-[10px] mr-1"></i> Kepala Dinas
                </span>
            </div>
            <p class="text-gray-500 text-sm mt-1">Ringkasan monitoring eksekutif operasional dan performa pengangkutan sampah.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('kepala.monitoring.index') }}" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium text-sm px-4 py-2 rounded-lg transition shadow-sm">
                <i class="fas fa-desktop"></i>
                <span>Monitoring Realtime</span>
            </a>
            <a href="{{ route('kepala.laporan.index') }}" class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm px-4 py-2 rounded-lg transition">
                <i class="fas fa-file-lines"></i>
                <span>Laporan</span>
            </a>
        </div>
    </div>

    {{-- SECTION 1: MASTER DATA SYSTEM (GLOBAL / KESELURUHAN) --}}
    <div class="space-y-3">
        <div class="border-l-4 border-green-600 pl-3">
            <h2 class="text-base font-bold text-gray-800">Master Data & Akumulasi Sistem</h2>
            <p class="text-xs text-gray-500">Akumulasi data master terdaftar di sistem</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Total Driver</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalDriver }}</h3>
                    <p class="text-[11px] text-gray-400 mt-1 font-medium">Driver aktif terdaftar</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Total Kendaraan</p>
                    <h3 class="text-2xl font-bold text-green-600 mt-1">{{ $totalKendaraan }}</h3>
                    <p class="text-[11px] text-gray-400 mt-1 font-medium">Armada truk aktif</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-xl">
                    <i class="fas fa-truck"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Total Sampah Kumulatif</p>
                    <h3 class="text-2xl font-bold text-blue-600 mt-1">{{ number_format($totalSampah) }} <span class="text-sm font-normal">Kg</span></h3>
                    <p class="text-[11px] text-gray-400 mt-1 font-medium">Akumulasi riil seluruh volume</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- PEMBATAS SECTION --}}
    <div class="relative flex py-2 items-center">
        <div class="flex-grow border-t border-gray-200"></div>
        <span class="flex-shrink mx-4 text-xs font-bold text-gray-500 uppercase tracking-wider px-3 py-1 bg-gray-100 rounded-full border border-gray-200">
            <i class="fas fa-filter text-green-600 mr-1.5"></i> Data Operasional Terfilter
        </span>
        <div class="flex-grow border-t border-gray-200"></div>
    </div>

    {{-- SECTION 2: OPERASIONAL BERDASARKAN FILTER --}}
    <div class="space-y-4">
        {{-- Filter Panel --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <form method="GET" action="{{ route('kepala.dashboard') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Tanggal Operasional</label>
                    <input type="date" name="tanggal" value="{{ $tanggal }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800 focus:border-green-500 focus:ring-1 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Driver</label>
                    <select name="driver" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800 focus:border-green-500 focus:ring-1 focus:ring-green-500">
                        <option value="">Semua Driver</option>
                        @foreach($drivers as $d)
                            <option value="{{ $d->id }}" {{ $driverId == $d->id ? 'selected' : '' }}>{{ $d->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg text-sm transition">
                        Filter Dashboard
                    </button>
                    <a href="{{ route('kepala.dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded-lg text-sm transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Cards Result Filtered Operasional --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Tugas Tanggal Ini</p>
                    <h3 class="text-2xl font-bold text-cyan-600 mt-1">{{ $pengangkutanHariIni }}</h3>
                    <p class="text-[11px] text-gray-400 mt-1 font-medium">Tanggal {{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-xl">
                    <i class="fas fa-clipboard-list"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Sedang Berjalan</p>
                    <h3 class="text-2xl font-bold text-yellow-600 mt-1">{{ $sedangBerjalan }}</h3>
                    <p class="text-[11px] text-gray-400 mt-1 font-medium">Armada aktif di jalan</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-yellow-50 text-yellow-600 flex items-center justify-center text-xl">
                    <i class="fas fa-spinner"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Selesai Tanggal Ini</p>
                    <h3 class="text-2xl font-bold text-teal-600 mt-1">{{ $selesai }}</h3>
                    <p class="text-[11px] text-gray-400 mt-1 font-medium">Tiba di TPA (Tanggal ini)</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl">
                    <i class="fas fa-circle-check"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Sampah Tanggal Ini</p>
                    <h3 class="text-2xl font-bold text-orange-600 mt-1">{{ number_format($totalSampahHariIni) }} <span class="text-sm font-normal">Kg</span></h3>
                    <p class="text-[11px] text-gray-400 mt-1 font-medium">Volume diangkut tanggal ini</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center text-xl">
                    <i class="fas fa-weight-hanging"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION 3: MONITORING TABLE --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-bold text-gray-800">Monitoring Pengangkutan Terbaru</h2>
            <a href="{{ route('kepala.monitoring.index') }}" class="text-xs font-semibold text-green-600 hover:underline">
                Selengkapnya →
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3.5">Tanggal</th>
                        <th class="px-5 py-3.5">Driver</th>
                        <th class="px-5 py-3.5">Kendaraan</th>
                        <th class="px-5 py-3.5 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($monitoring as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4 font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                            </td>
                            <td class="px-5 py-4 font-medium text-gray-800">{{ $item->driver->nama ?? '-' }}</td>
                            <td class="px-5 py-4 text-gray-600">{{ $item->optimasi->kendaraan->nama_kendaraan ?? '-' }}</td>
                            <td class="px-5 py-4 text-center">
                                @if($item->status == 'Selesai')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Selesai</span>
                                @elseif($item->status == 'Sedang Berjalan')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Sedang Berjalan</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">{{ $item->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-gray-400">Belum ada data monitoring terbaru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection