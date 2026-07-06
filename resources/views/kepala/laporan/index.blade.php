@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Laporan Pengangkutan</h1>
            <p class="text-sm text-gray-500 mt-1">Rekapitulasi seluruh kegiatan pengangkutan sampah.</p>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        @php
            $stats = [
                ['Total', $totalPengangkutan, 'text-gray-800'],
                ['Selesai', $selesai, 'text-green-600'],
                ['Berjalan', $berjalan, 'text-blue-600'],
                ['Belum', $belum, 'text-red-600'],
                ['Total Kg', number_format($totalSampah), 'text-emerald-600'],
            ];
        @endphp
        @foreach($stats as $stat)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider">{{ $stat[0] }}</p>
                <h2 class="text-2xl font-bold mt-1 {{ $stat[2] }}">{{ $stat[1] }}</h2>
            </div>
        @endforeach
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Awal</label>
                <input type="date" name="tanggal_awal" value="{{ $tanggalAwal }}" class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" value="{{ $tanggalAkhir }}" class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
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
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium transition">Filter</button>
                <a href="{{ route('kepala.laporan.print', request()->query()) }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                    Cetak
                </a>
            </div>
        </form>
    </div>

    {{-- Tabel Laporan --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-4 py-3 text-center w-12">No</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Driver</th>
                    <th class="px-4 py-3">Kendaraan</th>
                    <th class="px-4 py-3 text-center">TPS</th>
                    <th class="px-4 py-3">Muatan</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pengangkutans as $p)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-center">{{ $pengangkutans->firstItem() + $loop->index }}</td>
                    <td class="px-4 py-3 font-medium">{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
                    <td class="px-4 py-3">{{ $p->driver->nama }}</td>
                    <td class="px-4 py-3">{{ $p->optimasi->kendaraan->nama_kendaraan }}</td>
                    <td class="px-4 py-3 text-center">{{ $p->details->count() }}</td>
                    <td class="px-4 py-3">{{ number_format($p->muatan_sekarang) }} Kg</td>
                    <td class="px-4 py-3">
                        @php
                            $colors = ['Belum Berangkat' => 'bg-red-100 text-red-700', 'Sedang Berjalan' => 'bg-blue-100 text-blue-700', 'Selesai' => 'bg-green-100 text-green-700'];
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $colors[$p->status] ?? 'bg-gray-100' }}">
                            {{ $p->status }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('kepala.monitoring.show', $p->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-4 py-10 text-center text-gray-400 bg-gray-50/50">Belum ada data laporan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Rekapitulasi Bawah --}}
    <div class="max-w-md bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Rekapitulasi</h2>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between border-b pb-2"><span class="text-gray-600">Total Pengangkutan</span> <span class="font-bold">{{ $totalPengangkutan }}</span></div>
            <div class="flex justify-between border-b pb-2"><span class="text-gray-600">Total TPS</span> <span class="font-bold">{{ $totalTPS }}</span></div>
            <div class="flex justify-between"><span class="text-gray-600">Total Sampah</span> <span class="font-bold text-emerald-600">{{ number_format($totalSampah) }} Kg</span></div>
        </div>
    </div>

    @if($pengangkutans->hasPages())
        <div class="mt-4">{{ $pengangkutans->withQueryString()->links() }}</div>
    @endif
</div>
@endsection