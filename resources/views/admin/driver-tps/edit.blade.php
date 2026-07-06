@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Wilayah Driver</h1>
            <p class="text-sm text-gray-500">Tentukan TPS yang menjadi wilayah kerja driver.</p>
        </div>
        <a href="{{ route('admin.driver-tps.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg text-sm transition">
            Kembali
        </a>
    </div>

    {{-- Informasi Driver Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informasi Driver</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-sm">
            @php
                $driverInfo = [
                    'Kode Driver' => $driver->kode_driver,
                    'Nama Driver' => $driver->nama,
                    'Status'      => $driver->status,
                    'Jumlah TPS'  => $driver->tps->count() . ' TPS',
                ];
            @endphp
            @foreach($driverInfo as $label => $value)
                <div class="flex flex-col">
                    <span class="text-gray-500 font-medium">{{ $label }}</span>
                    @if($label === 'Status')
                        <span class="mt-1">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $value == 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $value }}
                            </span>
                        </span>
                    @else
                        <span class="font-semibold text-gray-900 mt-0.5">{{ $value }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    {{-- Form TPS Selection --}}
    <form action="{{ route('admin.driver-tps.update', $driver->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-6">Pilih Wilayah TPS</h2>

            @error('tps')
                <div class="mb-6 bg-red-50 text-red-700 border border-red-200 rounded-lg p-4 text-sm">
                    {{ $message }}
                </div>
            @enderror

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($tps as $item)
                    @php
                        $pemilik = $item->drivers->first();
                        $disable = $pemilik && $pemilik->id != $driver->id;
                    @endphp
                    
                    <label class="border rounded-xl p-4 transition-all duration-200 cursor-pointer flex items-start gap-3 
                        {{ $disable ? 'bg-gray-50 border-gray-200 opacity-75 cursor-not-allowed' : 'border-gray-200 hover:border-blue-500 hover:bg-blue-50/50' }}">
                        
                        <input type="checkbox" name="tps[]" value="{{ $item->id }}" 
                            class="mt-1 h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            {{ $driver->tps->contains($item->id) ? 'checked' : '' }} 
                            {{ $disable ? 'disabled' : '' }}>
                        
                        <div class="flex-1">
                            <h3 class="text-sm font-bold text-gray-800">{{ $item->nama_tps }}</h3>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $item->alamat }}</p>
                            <p class="text-xs mt-2 text-gray-600">Kapasitas: <span class="font-semibold">{{ number_format($item->kapasitas) }} Kg</span></p>
                            
                            @if($disable)
                                <div class="mt-2 text-xs text-red-600 bg-red-50 px-2 py-1 rounded inline-block">
                                    🔒 Digunakan: <b>{{ $pemilik->nama }}</b>
                                </div>
                            @endif
                        </div>
                    </label>
                @endforeach
            </div>

            <div class="mt-8 flex justify-end gap-3 pt-6 border-t">
                <a href="{{ route('admin.driver-tps.index') }}" class="text-gray-500 hover:text-gray-800 font-medium text-sm px-4 py-2 transition">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg text-sm shadow-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection