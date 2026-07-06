@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
        <p class="text-gray-500">Selamat datang kembali, {{ auth()->user()->name }}</p>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $cards = [
                ['Driver', $totalDriver, 'bg-blue-500', 'text-blue-600'],
                ['Kendaraan', $totalKendaraan, 'bg-green-500', 'text-green-600'],
                ['TPS', $totalTPS, 'bg-yellow-500', 'text-yellow-600'],
                ['TPA', $totalTPA, 'bg-red-500', 'text-red-600'],
                ['Pool', $totalPool, 'bg-indigo-500', 'text-indigo-600'],
                ['Optimasi', $totalOptimasi, 'bg-purple-500', 'text-purple-600'],
                ['Pengangkutan', $totalPengangkutan, 'bg-cyan-500', 'text-cyan-600'],
                ['Sampah', $totalSampah . ' Kg', 'bg-orange-500', 'text-orange-600'],
            ];
        @endphp

        @foreach($cards as $card)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
            <div class="text-gray-500 text-sm font-medium">{{ $card[0] }}</div>
            <div class="mt-2 text-2xl font-bold text-gray-800">{{ $card[1] }}</div>
            <div class="mt-4 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="{{ $card[2] }} h-full rounded-full"></div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Tabel Section --}}
    <div class="grid lg:grid-cols-2 gap-6">
        
        {{-- Pengangkutan Terbaru --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 font-bold text-gray-800 flex justify-between items-center">
                Pengangkutan Terbaru
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="p-4 text-left">Kode</th>
                            <th class="p-4 text-left">Driver</th>
                            <th class="p-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pengangkutanTerbaru as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 font-semibold text-gray-700">{{ $item->kode_pengangkutan }}</td>
                            <td class="p-4">{{ $item->driver->nama }}</td>
                            <td class="p-4 text-center">
                                <span class="px-2 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold">{{ $item->status }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-6 text-gray-400 italic">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Optimasi Terbaru --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 font-bold text-gray-800 flex justify-between items-center">
                Optimasi Terbaru
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="p-4 text-left">Kode</th>
                            <th class="p-4 text-left">Driver</th>
                            <th class="p-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($optimasiTerbaru as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 font-semibold text-gray-700">{{ $item->kode_optimasi }}</td>
                            <td class="p-4">{{ $item->driver->nama }}</td>
                            <td class="p-4 text-center">
                                <span class="px-2 py-1 rounded-full bg-green-50 text-green-700 text-xs font-bold">{{ $item->status }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-6 text-gray-400 italic">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection