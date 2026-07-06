@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data TPS</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola seluruh data Tempat Penampungan Sementara.</p>
        </div>
        <a href="{{ route('admin.tps.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg shadow-sm transition">
            + Tambah TPS
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Search --}}
    <form method="GET" class="max-w-md">
        <div class="flex gap-2">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari TPS..." class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm">
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-5 rounded-lg text-sm font-medium transition">
                Cari
            </button>
        </div>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-4 py-3.5 text-center w-12">No</th>
                    <th class="px-4 py-3.5">Kode</th>
                    <th class="px-4 py-3.5">Nama TPS</th>
                    <th class="px-4 py-3.5">Alamat</th>
                    <th class="px-4 py-3.5">Kapasitas</th>
                    <th class="px-4 py-3.5">Status</th>
                    <th class="px-4 py-3.5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($tps as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-center">{{ $tps->firstItem() + $loop->index }}</td>
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $item->kode_tps }}</td>
                    <td class="px-4 py-3">{{ $item->nama_tps }}</td>
                    <td class="px-4 py-3 text-xs">{{ Str::limit($item->alamat, 40) }}</td>
                    <td class="px-4 py-3">{{ number_format($item->kapasitas) }} Kg</td>
                    <td class="px-4 py-3">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $item->status == 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('admin.tps.show', $item->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Detail</a>
                            <a href="{{ route('admin.tps.edit', $item->id) }}" class="text-yellow-600 hover:text-yellow-800 font-medium">Edit</a>
                            <form action="{{ route('admin.tps.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data TPS ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-10 text-center text-gray-400 bg-gray-50/50">
                        Belum ada data TPS.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($tps->hasPages())
        <div class="mt-4">
            {{ $tps->withQueryString()->links() }}
        </div>
    @endif

</div>
@endsection