@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Kepala Dinas</h1>
        <p class="text-sm text-gray-500 mt-1">Ringkasan monitoring operasional pengangkutan sampah.</p>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $cards = [
                ['Driver', $totalDriver, 'text-gray-800'],
                ['Kendaraan', $totalKendaraan, 'text-gray-800'],
                ['Total Pengangkutan', $totalPengangkutan, 'text-gray-800'],
                ['Hari Ini', $pengangkutanHariIni, 'text-blue-600'],
                ['Berjalan', $sedangBerjalan, 'text-indigo-600'],
                ['Selesai', $selesai, 'text-green-600'],
                ['Total Sampah', number_format($totalSampah) . ' Kg', 'text-emerald-600'],
            ];
        @endphp

        @foreach($cards as $card)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 transition hover:shadow-md">
                <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider">{{ $card[0] }}</p>
                <h2 class="text-2xl font-bold mt-2 {{ $card[2] }}">{{ $card[1] }}</h2>
            </div>
        @endforeach
    </div>

    {{-- Monitoring Terbaru --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 border-b border-gray-100 bg-gray-50/50">
            <h2 class="font-bold text-gray-800">Monitoring Pengangkutan Terbaru</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Driver</th>
                        <th class="px-4 py-3">Kendaraan</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($monitoring as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3">{{ $item->driver->nama }}</td>
                            <td class="px-4 py-3">{{ $item->optimasi->kendaraan->nama_kendaraan }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $color = [
                                        'Belum Berangkat' => 'bg-red-100 text-red-700',
                                        'Sedang Berjalan' => 'bg-blue-100 text-blue-700',
                                        'Selesai'         => 'bg-green-100 text-green-700'
                                    ];
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $color[$item->status] ?? 'bg-gray-100' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-400">Belum ada data monitoring terbaru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection