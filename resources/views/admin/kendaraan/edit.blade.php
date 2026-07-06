@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Kendaraan</h1>
            <p class="text-sm text-gray-500">Perbarui data informasi kendaraan.</p>
        </div>
        <a href="{{ route('admin.kendaraan.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg text-sm transition">
            Kembali
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-6 md:p-8">
        <form action="{{ route('admin.kendaraan.update', $kendaraan) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Kode Kendaraan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Kendaraan</label>
                    <input type="text" value="{{ $kendaraan->kode_kendaraan }}" readonly 
                        class="w-full border-gray-200 bg-gray-50 text-gray-500 rounded-lg px-4 py-2 text-sm">
                </div>

                {{-- Driver --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Driver</label>
                    <select name="driver_id" class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 @error('driver_id') border-red-500 @enderror" required>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}" {{ old('driver_id', $kendaraan->driver_id) == $driver->id ? 'selected' : '' }}>
                                {{ $driver->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('driver_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Nama Kendaraan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kendaraan</label>
                    <input type="text" name="nama_kendaraan" value="{{ old('nama_kendaraan', $kendaraan->nama_kendaraan) }}" 
                        class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @error('nama_kendaraan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Nomor Polisi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Polisi</label>
                    <input type="text" name="nomor_polisi" value="{{ old('nomor_polisi', $kendaraan->nomor_polisi) }}" 
                        class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm uppercase focus:ring-blue-500 focus:border-blue-500" required>
                    @error('nomor_polisi') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Kapasitas --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kapasitas (Kg)</label>
                    <input type="number" name="kapasitas" value="{{ old('kapasitas', $kendaraan->kapasitas) }}" min="1" 
                        class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @error('kapasitas') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="Aktif" {{ old('status', $kendaraan->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Perawatan" {{ old('status', $kendaraan->status) == 'Perawatan' ? 'selected' : '' }}>Perawatan</option>
                        <option value="Tidak Aktif" {{ old('status', $kendaraan->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
            </div>

            {{-- Footer --}}
            <div class="mt-8 flex items-center justify-end gap-3">
                <a href="{{ route('admin.kendaraan.index') }}" class="text-gray-500 hover:text-gray-800 font-medium text-sm transition">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2.5 rounded-lg text-sm shadow-sm transition">
                    Update Kendaraan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection