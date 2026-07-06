@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Driver</h1>
            <p class="text-sm text-gray-500">Informasi lengkap dan status akun driver.</p>
        </div>
        <a href="{{ route('admin.driver.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg text-sm transition">
            Kembali
        </a>
    </div>

    {{-- Data Driver --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informasi Profil</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 text-sm">
            @php
                $data = [
                    'Kode Driver' => $driver->kode_driver,
                    'Nama Driver' => $driver->nama,
                    'NIK'         => $driver->nik,
                    'Nomor HP'    => $driver->no_hp,
                    'Jenis Kelamin' => $driver->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
                    'Alamat'      => $driver->alamat,
                    'Tanggal Daftar' => $driver->created_at->format('d M Y')
                ];
            @endphp

            @foreach($data as $label => $value)
                <div class="flex flex-col">
                    <span class="text-gray-500 font-medium">{{ $label }}</span>
                    <span class="font-semibold text-gray-900 mt-0.5">{{ $value }}</span>
                </div>
            @endforeach

            <div class="flex flex-col">
                <span class="text-gray-500 font-medium">Status</span>
                <span class="mt-1">
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $driver->status == 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $driver->status }}
                    </span>
                </span>
            </div>
        </div>
    </div>

    {{-- Akun Login Driver --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Akun Login Driver</h2>

        @if($driver->user)
            <div class="border rounded-lg p-5 bg-green-50/50 border-green-100">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-sm">
                    <div>
                        <p class="text-gray-500">Status Akun</p>
                        <p class="font-semibold text-green-700 mt-1">Sudah Memiliki Akun</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Role</p>
                        <p class="font-semibold mt-1">{{ ucfirst($driver->user->roles->first()?->name ?? '-') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Email</p>
                        <p class="font-semibold mt-1">{{ $driver->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Password Awal</p>
                        <p class="font-semibold text-orange-600 mt-1">Default: password</p>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-green-200">
                    <form action="{{ route('admin.driver.reset-password', $driver->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mereset password driver ini?')">
                        @csrf
                        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                            Reset Password
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="border rounded-lg p-5 bg-yellow-50/50 border-yellow-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <p class="font-semibold text-red-600">Belum Memiliki Akun Login</p>
                    <p class="text-sm text-gray-600 mt-1">Driver ini belum dapat mengakses sistem.</p>
                </div>
                <a href="{{ route('admin.driver.create-account', $driver->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition whitespace-nowrap">
                    + Buat Akun Driver
                </a>
            </div>
        @endif
    </div>
</div>
@endsection