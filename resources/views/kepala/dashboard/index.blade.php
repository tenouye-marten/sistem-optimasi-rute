@extends('layouts.app')

@section('title', 'Dashboard Kepala Dinas - SIMPAS DLH')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Dashboard Eksekutif</h1>
                <span class="px-2.5 py-0.5 text-xs font-semibold text-green-700 bg-green-50 border border-green-200 rounded-full">Kepala Dinas</span>
            </div>
            <p class="text-gray-500 text-sm mt-1">Ringkasan monitoring operasional dan performa pengangkutan sampah (Tanggal: {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}).</p>
        </div>
        <div class="flex items-center gap-3">
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

    {{-- Filter Panel (Default Tanggal Hari Ini) --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('kepala.dashboard') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Tanggal Operasional (Default: Hari Ini)</label>
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
                <a href="{{ route('kepala.dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded-lg text-sm transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Executive Metric Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $cards = [
                ['label' => 'Total Driver', 'val' => $totalDriver, 'color' => 'text-gray-800', 'sub' => 'Driver aktif terdaftar'],
                ['label' => 'Total Kendaraan', 'val' => $totalKendaraan, 'color' => 'text-green-600', 'sub' => 'Armada truk aktif'],
                ['label' => 'Tugas Tanggal Ini', 'val' => $pengangkutanHariIni, 'color' => 'text-cyan-600', 'sub' => 'Tanggal ' . \Carbon\Carbon::parse($tanggal)->format('d/m/Y')],
                ['label' => 'Sedang Berjalan', 'val' => $sedangBerjalan, 'color' => 'text-yellow-600', 'sub' => 'Armada aktif di jalan'],
                ['label' => 'Selesai Tanggal Ini', 'val' => $selesai, 'color' => 'text-teal-600', 'sub' => 'Tiba di TPA (Tanggal ini)'],
                ['label' => 'Sampah Tanggal Ini', 'val' => number_format($totalSampahHariIni) . ' Kg', 'color' => 'text-orange-600', 'sub' => 'Volume diangkut tanggal ini'],
                ['label' => 'Total Sampah Kumulatif', 'val' => number_format($totalSampah) . ' Kg', 'color' => 'text-blue-600', 'sub' => 'Akumulasi riil seluruh volume'],
            ];
        @endphp

        @foreach($cards as $card)
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase">{{ $card['label'] }}</span>
            </div>
            <div class="mt-2">
                <span class="text-2xl font-bold {{ $card['color'] }}">{{ $card['val'] }}</span>
                <p class="text-[11px] text-gray-400 mt-1 font-medium">{{ $card['sub'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Monitoring Terbaru Table --}}
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