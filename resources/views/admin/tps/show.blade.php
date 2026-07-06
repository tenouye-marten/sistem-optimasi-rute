@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail TPS</h1>
            <p class="text-sm text-gray-500">Informasi lengkap Tempat Penampungan Sementara.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.tps.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg text-sm transition">
                Kembali
            </a>
            <a href="{{ route('admin.tps.edit', $tp->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg text-sm transition">
                Edit Data
            </a>
        </div>
    </div>

    {{-- Detail Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informasi TPS</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 text-sm">
            @php
                $details = [
                    'Kode TPS'      => $tp->kode_tps,
                    'Nama TPS'      => $tp->nama_tps,
                    'Kapasitas'     => number_format($tp->kapasitas) . ' Kg',
                    'Latitude'      => $tp->latitude,
                    'Longitude'     => $tp->longitude,
                    'Alamat'        => $tp->alamat,
                    'Tanggal Dibuat'=> $tp->created_at->format('d F Y, H:i'),
                ];
            @endphp

            @foreach($details as $label => $value)
                <div class="flex flex-col">
                    <span class="text-gray-500 font-medium">{{ $label }}</span>
                    <span class="font-semibold text-gray-900 mt-0.5">{{ $value }}</span>
                </div>
            @endforeach

            {{-- Status --}}
            <div class="flex flex-col">
                <span class="text-gray-500 font-medium">Status</span>
                <span class="mt-1">
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $tp->status == 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $tp->status }}
                    </span>
                </span>
            </div>
        </div>
    </div>

</div>
@endsection