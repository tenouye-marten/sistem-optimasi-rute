@extends('layouts.app')

@section('title', 'Laporan Pengangkutan - SIMPAS DLH')

@section('content')
<div class="space-y-6">

    {{-- Title & Export Buttons --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-bold text-gray-800">Laporan Pengangkutan</h1>
                <span class="px-2.5 py-0.5 text-xs font-semibold text-green-700 bg-green-50 border border-green-200 rounded-full">Rekapitulasi Periode</span>
            </div>
            <p class="text-sm text-gray-500 mt-1">
                @if($tanggalAwal && $tanggalAkhir)
                    Menampilkan rekapitulasi data periode <span class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($tanggalAwal)->format('d M Y') }}</span> s/d <span class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($tanggalAkhir)->format('d M Y') }}</span>.
                @else
                    Menampilkan rekapitulasi dari <span class="font-bold text-gray-800">seluruh riwayat operasional</span> (Gunakan filter untuk menyaring rentang tanggal).
                @endif
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.laporan.pdf', request()->query()) }}" target="_blank" class="bg-red-600 hover:bg-red-700 text-white font-medium text-sm px-4 py-2 rounded-lg transition">
                <i class="fas fa-file-pdf mr-1.5"></i> Export PDF
            </a>
            <a href="{{ route('admin.laporan.print', request()->query()) }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white font-medium text-sm px-4 py-2 rounded-lg transition">
                <i class="fas fa-print mr-1.5"></i> Cetak
            </a>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        @php
            $stats = [
                ['label' => 'Total Task Periode', 'value' => $totalPengangkutan, 'color' => 'text-gray-800', 'sub' => 'Total tugas pengangkutan'],
                ['label' => 'Selesai', 'value' => $selesai, 'color' => 'text-green-600', 'sub' => 'Telah bongkar di TPA'],
                ['label' => 'Berjalan', 'value' => $berjalan, 'color' => 'text-yellow-600', 'sub' => 'Sedang aktif di lapangan'],
                ['label' => 'Belum Berangkat', 'value' => $belum, 'color' => 'text-red-600', 'sub' => 'Menunggu jadwal'],
                ['label' => 'Total Sampah', 'value' => number_format($totalSampah) . ' Kg', 'color' => 'text-blue-600', 'sub' => 'Akumulasi riil volume TPS'],
            ];
        @endphp
        @foreach($stats as $stat)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase">{{ $stat['label'] }}</p>
                <h3 class="text-xl font-bold {{ $stat['color'] }} mt-1">{{ $stat['value'] }}</h3>
                <p class="text-[11px] text-gray-400 mt-1 font-medium">{{ $stat['sub'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Filter Panel --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Tanggal Awal</label>
                <input type="date" name="tanggal_awal" value="{{ $tanggalAwal }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" value="{{ $tanggalAkhir }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800">
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
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg text-sm transition">
                    Filter
                </button>
                <a href="{{ route('admin.laporan.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded-lg text-sm transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Laporan Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-center w-12">No</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Driver</th>
                        <th class="px-6 py-3">Kendaraan</th>
                        <th class="px-6 py-3 text-center">TPS</th>
                        <th class="px-6 py-3">Total Muatan</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pengangkutans as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-center text-gray-400">{{ $pengangkutans->firstItem() + $loop->index }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $p->driver->nama ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $p->optimasi->kendaraan->nama_kendaraan ?? '-' }}</td>
                        <td class="px-6 py-4 text-center font-bold text-green-600">{{ $p->details->count() }}</td>
                        <td class="px-6 py-4 font-bold text-gray-900">{{ number_format($p->total_sampah) }} Kg</td>
                        <td class="px-6 py-4">
                            @if($p->status == 'Selesai')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Selesai</span>
                            @elseif($p->status == 'Sedang Berjalan')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Berjalan</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Belum Berangkat</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.monitoring.show', $p->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-400">Belum ada data laporan yang sesuai filter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Bottom Rekapitulasi & Pagination --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h3 class="font-bold text-gray-800 mb-3">Rekapitulasi Data Periode Ini</h3>
            <div class="space-y-2 text-sm text-gray-600">
                <p>Total Task Pengangkutan: <span class="font-bold text-gray-900">{{ $totalPengangkutan }}</span></p>
                <p>Total Titik TPS Diangkut: <span class="font-bold text-gray-900">{{ $totalTPS }}</span></p>
                <p>Total Volume Sampah: <span class="font-bold text-green-600">{{ number_format($totalSampah) }} Kg</span></p>
            </div>
        </div>

        @if($pengangkutans->hasPages())
            <div class="flex items-center justify-end">
                {{ $pengangkutans->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>
@endsection