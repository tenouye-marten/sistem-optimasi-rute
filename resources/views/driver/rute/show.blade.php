@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Detail Rute Pengangkutan</h1>
            <p class="text-gray-500 mt-1">Ikuti urutan rute berikut untuk melakukan pengangkutan sampah.</p>
        </div>
        <a href="{{ route('driver.rute.index') }}" 
           class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg font-medium transition">
            Kembali
        </a>
    </div>

    {{-- Info Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Card: Driver --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold mb-4 text-gray-800">Informasi Driver</h2>
            <div class="space-y-3">
                <div class="flex justify-between border-b border-gray-50 pb-2">
                    <span class="text-gray-500">Nama Driver</span> 
                    <span class="font-semibold text-gray-900">{{ $optimasi->driver->nama }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-50 pb-2">
                    <span class="text-gray-500">Kendaraan</span> 
                    <span class="font-semibold text-gray-900">{{ $optimasi->kendaraan->nama_kendaraan }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-50 pb-2">
                    <span class="text-gray-500">No. Polisi</span> 
                    <span class="font-semibold text-gray-900">{{ $optimasi->kendaraan->nomor_polisi }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Kapasitas</span> 
                    <span class="font-bold text-blue-600">{{ number_format($optimasi->kendaraan->kapasitas) }} Kg</span>
                </div>
            </div>
        </div>

        {{-- Card: Ringkasan --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold mb-4 text-gray-800">Ringkasan Rute</h2>
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-blue-50 rounded-xl p-4 text-center">
                    <p class="text-blue-600 text-xs font-bold uppercase">TPS</p>
                    <h3 class="text-2xl font-bold text-blue-800 mt-1">{{ $optimasi->jumlah_tps }}</h3>
                </div>
                <div class="bg-green-50 rounded-xl p-4 text-center">
                    <p class="text-green-600 text-xs font-bold uppercase">Jarak</p>
                    <h3 class="text-2xl font-bold text-green-800 mt-1">{{ number_format($optimasi->total_jarak, 1) }}</h3>
                    <span class="text-[10px] text-green-700 font-bold">KM</span>
                </div>
                <div class="bg-orange-50 rounded-xl p-4 text-center">
                    <p class="text-orange-600 text-xs font-bold uppercase">Waktu</p>
                    <h3 class="text-2xl font-bold text-orange-800 mt-1">{{ $optimasi->estimasi_waktu }}</h3>
                    <span class="text-[10px] text-orange-700 font-bold">MNT</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Jalur Rute Visual --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold mb-5 text-gray-800">Jalur Pengangkutan</h2>
        <div class="flex flex-wrap items-center gap-2">
            <div class="bg-gray-800 text-white px-4 py-2 rounded-lg font-bold text-xs shadow-sm">
                POOL: {{ $optimasi->pool->nama_pool }}
            </div>
            @foreach($optimasi->details as $detail)
                <span class="text-gray-300 font-bold">→</span>
                <div class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold text-xs shadow-sm">
                    TPS {{ $detail->urutan }}: {{ $detail->tps->nama_tps }}
                </div>
            @endforeach
            <span class="text-gray-300 font-bold">→</span>
            <div class="bg-red-600 text-white px-4 py-2 rounded-lg font-bold text-xs shadow-sm">
                TPA: {{ $optimasi->tpa->nama_tpa }}
            </div>
        </div>
    </div>

    {{-- Daftar TPS --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h2 class="font-bold text-gray-800">Daftar TPS Yang Akan Dikunjungi</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 text-center w-16">No</th>
                        <th class="px-6 py-3">Nama TPS</th>
                        <th class="px-6 py-3">Alamat</th>
                        <th class="px-6 py-3 text-center">Jarak</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($optimasi->details as $detail)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-center font-bold text-gray-800">{{ $detail->urutan }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $detail->tps->nama_tps }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $detail->tps->alamat }}</td>
                            <td class="px-6 py-4 text-center font-medium">{{ number_format($detail->jarak, 2) }} Km</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Info Box & Action --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 bg-blue-50 border border-blue-100 rounded-xl p-5">
        <p class="text-blue-700 text-sm font-medium">
            Pastikan seluruh informasi rute sudah benar sebelum memulai pengangkutan.
        </p>
        
        @if(!$pengangkutan)
            <form action="{{ route('driver.pengangkutan.mulai', $optimasi) }}" method="POST">
                @csrf
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg transition">
                    🚀 Mulai Pengangkutan
                </button>
            </form>
        @elseif($pengangkutan->status == 'Sedang Berjalan')
            <a href="{{ route('driver.pengangkutan.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg transition">
                Lanjutkan Pengangkutan
            </a>
        @else
            <span class="px-8 py-3 rounded-xl bg-gray-200 text-gray-700 font-bold">
                Pengangkutan Hari Ini Sudah Selesai
            </span>
        @endif
    </div>
</div>
@endsection