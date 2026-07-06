@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Monitoring Pengangkutan</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau seluruh aktivitas real-time pengangkutan sampah.</p>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $stats = [
                ['label' => 'Hari Ini', 'value' => $totalHariIni, 'color' => 'gray'],
                ['label' => 'Sedang Berjalan', 'value' => $berjalan, 'color' => 'blue'],
                ['label' => 'Selesai', 'value' => $selesai, 'color' => 'green'],
                ['label' => 'Belum Berangkat', 'value' => $belum, 'color' => 'red'],
            ];
        @endphp
        @foreach($stats as $stat)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <p class="text-xs text-gray-500 uppercase font-semibold">{{ $stat['label'] }}</p>
                <h2 class="text-2xl font-bold mt-1 text-gray-800">{{ $stat['value'] }}</h2>
            </div>
        @endforeach
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ $tanggal }}" class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Driver</label>
                <select name="driver" class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Driver</option>
                    @foreach($drivers as $item)
                        <option value="{{ $item->id }}" {{ $driver == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    @foreach(['Belum Berangkat', 'Sedang Berjalan', 'Selesai'] as $s)
                        <option value="{{ $s }}" {{ $status == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-2 rounded-lg text-sm font-medium transition">
                Filter Data
            </button>
        </form>
    </div>

    {{-- Tabel Monitoring --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-4 py-3.5 text-center w-12">No</th>
                    <th class="px-4 py-3.5">Driver</th>
                    <th class="px-4 py-3.5">Kendaraan</th>
                    <th class="px-4 py-3.5">Kode Optimasi</th>
                    <th class="px-4 py-3.5">Muatan (Kg)</th>
                    <th class="px-4 py-3.5">Status</th>
                    <th class="px-4 py-3.5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pengangkutans as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-center">{{ $pengangkutans->firstItem() + $loop->index }}</td>
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $item->driver->nama }}</td>
                    <td class="px-4 py-3">{{ $item->optimasi->kendaraan->nama_kendaraan }}</td>
                    <td class="px-4 py-3 font-mono text-xs">{{ $item->optimasi->kode_optimasi }}</td>
                    <td class="px-4 py-3">
                        <span class="font-medium">{{ number_format($item->muatan_sekarang) }}</span> 
                        <span class="text-gray-400">/ {{ number_format($item->kapasitas_kendaraan) }}</span>
                    </td>
                    <td class="px-4 py-3">
                        @php
                            $colors = [
                                'Belum Berangkat' => 'bg-red-100 text-red-700',
                                'Sedang Berjalan' => 'bg-blue-100 text-blue-700',
                                'Selesai'         => 'bg-green-100 text-green-700'
                            ];
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $colors[$item->status] ?? 'bg-gray-100' }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('admin.monitoring.show', $item) }}" class="text-blue-600 hover:text-blue-800 font-medium">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-10 text-center text-gray-400 bg-gray-50/50">Belum ada data monitoring.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($pengangkutans->hasPages())
        <div class="mt-4">
            {{ $pengangkutans->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection