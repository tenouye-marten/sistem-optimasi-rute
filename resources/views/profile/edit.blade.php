@extends('layouts.app')

@section('title', 'Edit Profil - SIMPAS DLH')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-1">Pengaturan Profil</h1>
        <p class="text-sm text-gray-500 mb-6">Perbarui informasi profil akun Anda.</p>

        @if (session('status') === 'profile-updated')
            <div class="p-3.5 mb-6 rounded-lg bg-green-50 text-green-700 text-sm font-medium border border-green-200">
                Profil berhasil diperbarui.
            </div>
        @endif

        <form method="post" action="{{ route('profile.update') }}" class="space-y-4 max-w-xl">
            @csrf
            @method('patch')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full border border-gray-300 rounded-lg px-3.5 py-2 text-sm text-gray-800 focus:border-green-600 focus:ring-2 focus:ring-green-600/20">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full border border-gray-300 rounded-lg px-3.5 py-2 text-sm text-gray-800 focus:border-green-600 focus:ring-2 focus:ring-green-600/20">
            </div>

            <div class="pt-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2.5 rounded-lg text-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection