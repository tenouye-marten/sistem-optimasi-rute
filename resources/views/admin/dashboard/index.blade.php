@extends('layouts.app')

@section('title', 'Dashboard Admin - SIMPAS DLH')

@section('content')
<div class="space-y-6">

    {{-- Title & Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 bg-white p-5 rounded-xl shadow-sm border border-gray-100">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
            <p class="text-sm text-gray-500">Ringkasan data master dan operasional pengangkutan sampah.</p>
        </div>
        <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-50 border border-green-200 rounded-full">
            Tanggal: {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}
        </span>
    </div>

    {{-- Filter Panel (Default Tanggal Hari Ini) --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('admin.dashboard') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Tanggal Filter (Default: Hari Ini)</label>
                <input type="date" name="tanggal" value="{{ $tanggal }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Driver</label>
                <select name="driver" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800">
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
                <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded-lg text-sm transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Grid Card Stat --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        {{-- Master Data --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Total Driver</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalDriver }}</h3>
                <p class="text-[11px] text-gray-400 mt-1 font-medium">Driver terdaftar di sistem</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="fas fa-user-tie"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Total Kendaraan</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalKendaraan }}</h3>
                <p class="text-[11px] text-gray-400 mt-1 font-medium">Armada truk aktif</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-xl">
                <i class="fas fa-truck"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Total TPS</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalTPS }}</h3>
                <p class="text-[11px] text-gray-400 mt-1 font-medium">Titik penampungan sementara</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-yellow-50 text-yellow-600 flex items-center justify-center text-xl">
                <i class="fas fa-dumpster"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Total TPA</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalTPA }}</h3>
                <p class="text-[11px] text-gray-400 mt-1 font-medium">Lokasi pemrosesan akhir</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl">
                <i class="fas fa-recycle"></i>
            </div>
        </div>

        {{-- Operasional Filtered (Hari Ini / Tanggal Terpilih) --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Tugas Tanggal Ini</p>
                <h3 class="text-2xl font-bold text-cyan-600 mt-1">{{ $pengangkutanHariIni }}</h3>
                <p class="text-[11px] text-cyan-600 mt-1 font-medium">{{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-xl">
                <i class="fas fa-clipboard-list"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Sedang Berjalan</p>
                <h3 class="text-2xl font-bold text-yellow-600 mt-1">{{ $pengangkutanBerjalan }}</h3>
                <p class="text-[11px] text-gray-400 mt-1 font-medium">Armada di jalan (Tanggal ini)</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-yellow-50 text-yellow-600 flex items-center justify-center text-xl">
                <i class="fas fa-spinner"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Selesai</p>
                <h3 class="text-2xl font-bold text-green-600 mt-1">{{ $pengangkutanSelesai }}</h3>
                <p class="text-[11px] text-gray-400 mt-1 font-medium">Tiba di TPA (Tanggal ini)</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-xl">
                <i class="fas fa-circle-check"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Sampah Tanggal Ini</p>
                <h3 class="text-2xl font-bold text-orange-600 mt-1">{{ number_format($totalSampahPeriode) }} <span class="text-sm font-normal">Kg</span></h3>
                <p class="text-[11px] text-gray-400 mt-1 font-medium">Hasil diangkut tanggal ini</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center text-xl">
                <i class="fas fa-weight-hanging"></i>
            </div>
        </div>

    </div>

    {{-- Recent Tables --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Pengangkutan Terbaru --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 text-lg mb-4">Aktivitas Pengangkutan</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Driver</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pengangkutanTerbaru as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-800">{{ $item->driver->nama ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $item->status == 'Selesai' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-gray-400">Belum ada data pada tanggal ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Optimasi Terbaru --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 text-lg mb-4">Optimasi Rute Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">Kode</th>
                            <th class="px-4 py-3">Driver</th>
                            <th class="px-4 py-3">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($optimasiTerbaru as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-mono text-xs">{{ $item->kode_optimasi }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-800">{{ $item->driver->nama ?? '-' }}</td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-gray-400">Belum ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection