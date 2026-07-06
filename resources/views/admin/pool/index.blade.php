@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Pool</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola seluruh data Pool DLH.</p>
        </div>
        <a href="{{ route('admin.pool.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg shadow-sm transition">
            + Tambah Pool
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
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari pool..." class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm">
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
                    <th class="px-4 py-3.5">Nama Pool</th>
                    <th class="px-4 py-3.5">Latitude</th>
                    <th class="px-4 py-3.5">Longitude</th>
                    <th class="px-4 py-3.5">Status</th>
                    <th class="px-4 py-3.5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pools as $pool)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-center">{{ $pools->firstItem() + $loop->index }}</td>
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $pool->kode_pool }}</td>
                    <td class="px-4 py-3">{{ $pool->nama_pool }}</td>
                    <td class="px-4 py-3 font-mono text-xs">{{ $pool->latitude }}</td>
                    <td class="px-4 py-3 font-mono text-xs">{{ $pool->longitude }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $pool->status == 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $pool->status }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('admin.pool.show', $pool->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Detail</a>
                            <a href="{{ route('admin.pool.edit', $pool->id) }}" class="text-yellow-600 hover:text-yellow-800 font-medium">Edit</a>
                            <form action="{{ route('admin.pool.destroy', $pool->id) }}" method="POST" onsubmit="return confirm('Hapus data Pool?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-10 text-center text-gray-400 bg-gray-50/50">
                        Belum ada data Pool.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($pools->hasPages())
        <div class="mt-4">
            {{ $pools->withQueryString()->links() }}
        </div>
    @endif

</div>
@endsection