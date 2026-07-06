@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Pool</h1>
            <p class="text-sm text-gray-500">Perbarui data informasi Pool.</p>
        </div>
        <a href="{{ route('admin.pool.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg text-sm transition">
            Kembali
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-6 md:p-8">
        <form action="{{ route('admin.pool.update', $pool->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Kode Pool --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pool</label>
                    <input type="text" value="{{ $pool->kode_pool }}" readonly 
                        class="w-full border-gray-200 bg-gray-50 text-gray-500 rounded-lg px-4 py-2 text-sm">
                </div>

                {{-- Nama Pool --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pool</label>
                    <input type="text" name="nama_pool" value="{{ old('nama_pool', $pool->nama_pool) }}" 
                        class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 @error('nama_pool') border-red-500 @enderror">
                    @error('nama_pool') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Latitude --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                    <input type="text" name="latitude" value="{{ old('latitude', $pool->latitude) }}" 
                        class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('latitude') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Longitude --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                    <input type="text" name="longitude" value="{{ old('longitude', $pool->longitude) }}" 
                        class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('longitude') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Status --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="Aktif" {{ old('status', $pool->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ old('status', $pool->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
            </div>

            {{-- Alamat --}}
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="alamat" rows="3" class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('alamat', $pool->alamat) }}</textarea>
                @error('alamat') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="mt-8 flex items-center justify-end gap-3">
                <a href="{{ route('admin.pool.index') }}" class="text-gray-500 hover:text-gray-800 font-medium text-sm transition">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2.5 rounded-lg text-sm shadow-sm transition">
                    Update Pool
                </button>
            </div>
        </form>
    </div>
</div>
@endsection