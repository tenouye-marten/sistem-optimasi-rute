@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Header & Action Buttons --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Driver</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui data  driver.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.driver.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg text-sm transition">
                Kembali
            </a>
         
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-6 md:p-8">
        <form action="{{ route('admin.driver.update', $driver->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Kode Driver --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Driver</label>
                    <input type="text" value="{{ $driver->kode_driver }}" class="w-full border-gray-200 bg-gray-50 text-gray-500 rounded-lg px-4 py-2 text-sm" readonly>
                </div>

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Driver</label>
                    <input type="text" name="nama" value="{{ old('nama', $driver->nama) }}" class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('nama') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- NIK --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                    <input type="text" name="nik" value="{{ old('nik', $driver->nik) }}" class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('nik') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- No HP --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $driver->no_hp) }}" class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('no_hp') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Jenis Kelamin --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="L" {{ old('jenis_kelamin', $driver->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $driver->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="Aktif" {{ old('status', $driver->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ old('status', $driver->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
            </div>

            {{-- Alamat --}}
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="alamat" rows="3" class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('alamat', $driver->alamat) }}</textarea>
            </div>

            {{-- Submit Buttons --}}
            <div class="mt-8 flex items-center gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2.5 rounded-lg text-sm transition shadow-sm">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.driver.index') }}" class="text-gray-500 hover:text-gray-800 text-sm font-medium transition">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
@endsection