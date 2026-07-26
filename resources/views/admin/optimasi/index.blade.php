@extends('layouts.app')

@section('title', 'Optimasi Rute - SIMPAS DLH')

@section('content')
<div class="space-y-6">

    {{-- Header & Action Button --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Optimasi Rute</h1>
            <p class="text-sm text-slate-500 mt-1">Perhitungan rute pengangkutan efisien dengan metode Nearest Neighbor.</p>
        </div>
        <a href="{{ route('admin.optimasi.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl shadow-xs transition-all hover:shadow-sm">
            <i class="fas fa-route"></i>
            <span>Generate Optimasi</span>
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3.5 rounded-xl text-sm flex items-center gap-3 shadow-xs">
            <i class="fas fa-circle-check text-emerald-600 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Search Filter --}}
    <form method="GET" class="max-w-md">
        <div class="relative flex items-center">
            <i class="fas fa-search absolute left-3.5 text-slate-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode atau nama driver..." class="w-full border border-slate-200 rounded-xl pl-10 pr-24 py-2.5 text-sm text-slate-800 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 shadow-xs transition-all">
            <button type="submit" class="absolute right-1.5 bg-slate-800 hover:bg-slate-900 text-white px-4 py-1.5 rounded-lg text-xs font-semibold transition-all">
                Cari
            </button>
        </div>
    </form>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3.5">Kode</th>
                        <th class="px-5 py-3.5">Driver</th>
                        <th class="px-5 py-3.5 text-center">TPS</th>
                        <th class="px-5 py-3.5">Jarak</th>
                        <th class="px-5 py-3.5">Estimasi</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($optimasi as $item)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-5 py-3.5 font-bold text-slate-800">{{ $item->kode_optimasi }}</td>
                        <td class="px-5 py-3.5 font-medium text-slate-700">{{ $item->driver->nama ?? '-' }}</td>
                        <td class="px-5 py-3.5 text-center font-bold text-emerald-600 bg-emerald-50/50 rounded-lg">{{ $item->jumlah_tps }}</td>
                        <td class="px-5 py-3.5 font-mono text-slate-800 font-semibold">{{ number_format($item->total_jarak, 2) }} Km</td>
                        <td class="px-5 py-3.5 text-slate-500">{{ $item->estimasi_waktu }} Menit</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $item->status == 'Aktif' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $item->status == 'Aktif' ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.optimasi.show', $item) }}" class="p-2 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Detail">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                <form action="{{ route('admin.optimasi.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus data optimasi rute ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus">
                                        <i class="fas fa-trash-can text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-10 text-center text-slate-400">
                            Belum ada data optimasi rute.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if($optimasi->hasPages())
        <div class="mt-4">
            {{ $optimasi->withQueryString()->links() }}
        </div>
    @endif

</div>
@endsection