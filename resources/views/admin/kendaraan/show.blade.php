@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Kendaraan</h1>
            <p class="text-sm text-gray-500">Informasi lengkap mengenai data kendaraan.</p>
        </div>
        <a href="{{ route('admin.kendaraan.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg text-sm transition">
            Kembali
        </a>
    </div>

    {{-- Detail Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informasi Kendaraan</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 text-sm">
            @php
                $details = [
                    'Kode Kendaraan' => $kendaraan->kode_kendaraan,
                    'Driver'         => $kendaraan->driver?->nama ?? '-',
                    'Nama Kendaraan' => $kendaraan->nama_kendaraan,
                    'Nomor Polisi'   => $kendaraan->nomor_polisi,
                    'Kapasitas'      => number_format($kendaraan->kapasitas, 0, ',', '.') . ' Kg',
                    'Dibuat Pada'    => $kendaraan->created_at->format('d M Y, H:i'),
                    'Terakhir Diubah'=> $kendaraan->updated_at->format('d M Y, H:i'),
                ];
            @endphp

            @foreach($details as $label => $value)
                <div class="flex flex-col">
                    <span class="text-gray-500 font-medium">{{ $label }}</span>
                    <span class="font-semibold text-gray-900 mt-0.5">{{ $value }}</span>
                </div>
            @endforeach

            {{-- Status Khusus --}}
            <div class="flex flex-col">
                <span class="text-gray-500 font-medium">Status</span>
                <span class="mt-1">
                    @php
                        $statusColors = [
                            'Aktif' => 'bg-green-100 text-green-700',
                            'Perawatan' => 'bg-yellow-100 text-yellow-700',
                            'Tidak Aktif' => 'bg-red-100 text-red-700'
                        ];
                    @endphp
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$kendaraan->status] ?? 'bg-gray-100' }}">
                        {{ $kendaraan->status }}
                    </span>
                </span>
            </div>
        </div>
    </div>

</div>
@endsection