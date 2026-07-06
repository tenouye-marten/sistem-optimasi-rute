@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit TPS</h1>
            <p class="text-sm text-gray-500">Perbarui data Tempat Penampungan Sementara.</p>
        </div>
        <a href="{{ route('admin.tps.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg text-sm transition">
            Kembali
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-6 md:p-8">
        <form action="{{ route('admin.tps.update', $tp->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Kode TPS --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode TPS</label>
                    <input type="text" value="{{ $tp->kode_tps }}" readonly 
                        class="w-full border-gray-200 bg-gray-50 text-gray-500 rounded-lg px-4 py-2 text-sm">
                </div>

                {{-- Nama TPS --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama TPS</label>
                    <input type="text" name="nama_tps" value="{{ old('nama_tps', $tp->nama_tps) }}" placeholder="Contoh: TPS Pasar Baru" 
                        class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 @error('nama_tps') border-red-500 @enderror">
                    @error('nama_tps') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Kapasitas --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kapasitas (Kg)</label>
                    <input type="number" name="kapasitas" value="{{ old('kapasitas', $tp->kapasitas) }}" placeholder="750" 
                        class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 @error('kapasitas') border-red-500 @enderror">
                    @error('kapasitas') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="Aktif" {{ old('status', $tp->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ old('status', $tp->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                {{-- Latitude --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                    <input type="text" name="latitude" value="{{ old('latitude', $tp->latitude) }}" placeholder="-2.561234" 
                        class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('latitude') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Longitude --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                    <input type="text" name="longitude" value="{{ old('longitude', $tp->longitude) }}" placeholder="140.718345" 
                        class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('longitude') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Alamat --}}
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="alamat" rows="3" placeholder="Masukkan alamat lengkap TPS" 
                    class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('alamat', $tp->alamat) }}</textarea>
                @error('alamat') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="mt-8 flex items-center justify-end gap-3">
                <a href="{{ route('admin.tps.index') }}" class="text-gray-500 hover:text-gray-800 font-medium text-sm transition">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2.5 rounded-lg text-sm shadow-sm transition">
                    Update Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection