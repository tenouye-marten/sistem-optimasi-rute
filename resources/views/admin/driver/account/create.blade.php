@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Buat Akun Driver</h1>
            <p class="text-sm text-gray-500">Berikan akses login untuk driver ke dalam sistem.</p>
        </div>
        <a href="{{ route('admin.driver.show', $driver->id) }}" class="text-sm text-gray-500 hover:text-gray-800 font-medium transition">
            Kembali
        </a>
    </div>

    {{-- Form --}}
    <form action="{{ route('admin.driver.store-account', $driver->id) }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8">
        @csrf

        {{-- Read-only Info Grid --}}
        <div class="grid grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
            <div>
                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Kode Driver</p>
                <p class="text-sm font-semibold text-gray-700">{{ $driver->kode_driver }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Nama Driver</p>
                <p class="text-sm font-semibold text-gray-700">{{ $driver->nama }}</p>
            </div>
        </div>

        {{-- Input Utama: Email --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Email Login</label>
            <input type="email" name="email" value="{{ old('email') }}" 
                class="w-full border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror" 
                placeholder="Masukkan alamat email driver" required>
            @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        {{-- Hidden/Read-only Defaults --}}
        <div class="flex gap-6 mb-8 text-sm text-gray-500">
            <div class="flex items-center gap-2">
                <span class="text-gray-400">🔑</span>
                <span>Password: <strong class="text-gray-700">password</strong></span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-gray-400">🛡️</span>
                <span>Role: <strong class="text-gray-700">Driver</strong></span>
            </div>
        </div>

        {{-- Action --}}
        <div class="pt-4 border-t">
            <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-medium px-8 py-2.5 rounded-lg text-sm shadow-sm transition">
                Simpan Akun Driver
            </button>
        </div>
    </form>

</div>
@endsection