@extends('layouts.app')

@section('title', 'Monitoring Pengangkutan - Kepala Dinas')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-bold text-gray-800">Monitoring Pengangkutan</h1>
                <span class="px-2.5 py-0.5 text-xs font-semibold text-blue-700 bg-blue-50 border border-blue-200 rounded-full">Real-time Per Hari</span>
            </div>
            <p class="text-sm text-gray-500 mt-1">
                Memantau kegiatan armada sampah pada tanggal <span class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</span>.
            </p>
        </div>
    </div>

    {{-- Stat Cards (Sensitif Tanggal Monitoring) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $stats = [
                ['label' => 'Total Task Tanggal Ini', 'value' => $totalHariIni, 'color' => 'text-gray-800', 'sub' => 'Total jadwal pengangkutan'],
                ['label' => 'Sedang Berjalan', 'value' => $berjalan, 'color' => 'text-yellow-600', 'sub' => 'Armada aktif di lapangan'],
                ['label' => 'Selesai', 'value' => $selesai, 'color' => 'text-green-600', 'sub' => 'Tugas selesai di TPA'],
                ['label' => 'Belum Berangkat', 'value' => $belum, 'color' => 'text-red-600', 'sub' => 'Menunggu jadwal berangkat'],
            ];
        @endphp
        @foreach($stats as $stat)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase">{{ $stat['label'] }}</p>
                <h3 class="text-2xl font-bold {{ $stat['color'] }} mt-1">{{ $stat['value'] }}</h3>
                <p class="text-[11px] text-gray-400 mt-1 font-medium">{{ $stat['sub'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Filter Panel --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Tanggal Operasional</label>
                <input type="date" name="tanggal" value="{{ $tanggal }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Driver</label>
                <select name="driver" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800">
                    <option value="">Semua Driver</option>
                    @foreach($drivers as $item)
                        <option value="{{ $item->id }}" {{ $driver == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800">
                    <option value="">Semua Status</option>
                    @foreach(['Belum Berangkat', 'Sedang Berjalan', 'Selesai'] as $s)
                        <option value="{{ $s }}" {{ $status == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg text-sm transition">
                Filter Data
            </button>
        </form>
    </div>

    {{-- Monitoring Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-center w-12">No</th>
                        <th class="px-6 py-3">Driver</th>
                        <th class="px-6 py-3">Kendaraan</th>
                        <th class="px-6 py-3">Kode Optimasi</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Muatan (Kg)</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pengangkutans as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-center text-gray-400">{{ $pengangkutans->firstItem() + $loop->index }}</td>
                        <td class="px-6 py-4 font-bold text-gray-900">{{ $item->driver->nama ?? '-' }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $item->optimasi->kendaraan->nama_kendaraan ?? '-' }}</td>
                        <td class="px-6 py-4 font-mono text-xs text-gray-600">{{ $item->optimasi->kode_optimasi ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            @if($item->status == 'Selesai')
                                <span class="font-bold text-green-600">{{ number_format($item->total_sampah) }} Kg</span>
                                <span class="text-gray-400 text-xs block">(Selesai Diangkut)</span>
                            @else
                                <span class="font-bold text-gray-900">{{ number_format($item->muatan_sekarang) }}</span> 
                                <span class="text-gray-400 text-xs">/ {{ number_format($item->kapasitas_kendaraan) }} Kg</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($item->status == 'Selesai')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Selesai</span>
                            @elseif($item->status == 'Sedang Berjalan')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Sedang Berjalan</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Belum Berangkat</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('kepala.monitoring.show', $item->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-400">Belum ada data monitoring pada tanggal ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($pengangkutans->hasPages())
        <div class="mt-4">
            {{ $pengangkutans->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection