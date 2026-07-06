@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Rute Saya</h1>
            <p class="text-gray-500">Daftar rute pengangkutan yang diberikan kepada Anda.</p>
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Pool</th>
                        <th class="px-6 py-4">TPA</th>
                        <th class="px-6 py-4 text-center">TPS</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($rutes as $rute)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($rute->tanggal_generate)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $rute->pool->nama_pool }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $rute->tpa->nama_tpa }}
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-gray-800">
                                {{ $rute->jumlah_tps }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($rute->status == 'Aktif')
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold uppercase tracking-wider">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-bold uppercase tracking-wider">
                                        {{ $rute->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('driver.rute.show', $rute) }}" 
                                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold transition text-xs">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-500">
                                <p>Belum ada rute yang tersedia.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $rutes->links() }}
    </div>

</div>

@endsection