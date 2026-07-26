@extends('layouts.app')

@section('title', 'Detail Monitoring - SIMPAS DLH')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Monitoring</h1>
            <p class="text-sm text-gray-500">Informasi lengkap proses pengangkutan sampah.</p>
        </div>
        <a href="{{ route('admin.monitoring.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg text-sm transition">
            Kembali
        </a>
    </div>

    {{-- Info Card --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $info = [
                'Driver'     => $pengangkutan->driver->nama ?? '-',
                'Kendaraan'  => $pengangkutan->optimasi->kendaraan->nama_kendaraan ?? '-',
                'Pool'       => $pengangkutan->optimasi->pool->nama_pool ?? '-',
                'TPA'        => $pengangkutan->optimasi->tpa->nama_tpa ?? '-',
            ];
        @endphp
        @foreach($info as $label => $value)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <p class="text-xs text-gray-500 font-medium uppercase">{{ $label }}</p>
                <h3 class="font-bold text-gray-900 mt-1 truncate" title="{{ $value }}">{{ $value }}</h3>
            </div>
        @endforeach
    </div>

    {{-- Status Row --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 grid md:grid-cols-3 gap-6 text-sm">
        <div>
            <p class="text-gray-500 font-medium">Tanggal</p>
            <h4 class="font-bold text-gray-900 mt-1">{{ \Carbon\Carbon::parse($pengangkutan->tanggal)->format('d M Y') }}</h4>
        </div>
        <div>
            <p class="text-gray-500 font-medium">Status Pengangkutan</p>
            <span class="inline-block mt-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold">{{ $pengangkutan->status }}</span>
        </div>
        <div>
            <p class="text-gray-500 font-medium">Status Perjalanan</p>
            <span class="inline-block mt-2 px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-semibold">{{ $pengangkutan->status_perjalanan ?? '-' }}</span>
        </div>
    </div>

    {{-- Progress Muatan --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-end mb-3">
            <div>
                <h3 class="font-bold text-gray-800">Progress Muatan</h3>
                <p class="text-xs text-gray-500 mt-1">
                    @if($pengangkutan->status == 'Selesai')
                        <span class="text-green-600 font-semibold">100% (Selesai Diangkut & Dibuang di TPA)</span>
                    @else
                        {{ $persenMuatan }}% dari kapasitas
                    @endif
                </p>
            </div>
            @if($pengangkutan->status == 'Selesai')
                <span class="font-bold text-green-600 text-lg">{{ number_format($pengangkutan->total_sampah) }} Kg</span>
            @else
                <span class="font-bold text-gray-900">{{ number_format($pengangkutan->muatan_sekarang) }} / {{ number_format($pengangkutan->kapasitas_kendaraan) }} Kg</span>
            @endif
        </div>
        <div class="w-full bg-gray-100 rounded-full h-4 overflow-hidden border border-gray-200">
            <div class="bg-green-600 h-full rounded-full transition-all duration-500" style="width: {{ min($persenMuatan, 100) }}%"></div>
        </div>
    </div>

    {{-- Progress TPS Tabel --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-bold text-gray-800">Progress TPS</h2>
        </div>
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-50 border-b border-gray-100 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-center w-16">No</th>
                    <th class="px-6 py-3">TPS</th>
                    <th class="px-6 py-3">Volume (Kg)</th>
                    <th class="px-6 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($pengangkutan->details as $detail)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-center">{{ $detail->urutan }}</td>
                    <td class="px-6 py-3 font-medium text-gray-900">{{ $detail->tps->nama_tps ?? '-' }}</td>
                    <td class="px-6 py-3 font-semibold text-gray-800">{{ number_format($detail->volume_diangkut) }}</td>
                    <td class="px-6 py-3">
                        @php
                            $statusColors = [
                                'Belum'   => 'bg-gray-100 text-gray-700',
                                'Proses'  => 'bg-yellow-100 text-yellow-700',
                                'Selesai' => 'bg-green-100 text-green-700'
                            ];
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$detail->status] ?? 'bg-gray-100' }}">
                            {{ $detail->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Ringkasan Bawah --}}
    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 mb-3">Ringkasan TPS</h3>
            <div class="space-y-1 text-sm text-gray-600">
                <p>Total TPS: <span class="font-semibold text-gray-900">{{ $totalTPS }}</span></p>
                <p>TPS Selesai: <span class="font-semibold text-green-600">{{ $selesaiTPS }}</span></p>
                <p>TPS Belum: <span class="font-semibold text-red-600">{{ $totalTPS - $selesaiTPS }}</span></p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 mb-3">Waktu</h3>
            <div class="space-y-1 text-sm text-gray-600">
                <p>Mulai: <span class="font-semibold text-gray-900">{{ $pengangkutan->waktu_mulai ?? '-' }}</span></p>
                <p>Selesai: <span class="font-semibold text-gray-900">{{ $pengangkutan->waktu_selesai ?? '-' }}</span></p>
            </div>
        </div>
    </div>
</div>
@endsection