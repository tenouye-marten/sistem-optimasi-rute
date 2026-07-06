@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail TPA</h1>
            <p class="text-sm text-gray-500">Informasi lengkap Tempat Pemrosesan Akhir.</p>
        </div>
        <a href="{{ route('admin.tpa.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg text-sm transition">
            Kembali
        </a>
    </div>

    {{-- Detail Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informasi TPA</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 text-sm">
            @php
                $details = [
                    'Kode TPA'      => $tpa->kode_tpa,
                    'Nama TPA'      => $tpa->nama_tpa,
                    'Alamat'        => $tpa->alamat,
                    'Latitude'      => $tpa->latitude,
                    'Longitude'     => $tpa->longitude,
                    'Tanggal Dibuat'=> $tpa->created_at->format('d F Y, H:i'),
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
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $tpa->status == 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $tpa->status }}
                    </span>
                </span>
            </div>
        </div>
    </div>

</div>
@endsection