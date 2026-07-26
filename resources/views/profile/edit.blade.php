@extends('layouts.app')

@section('title', 'Pengaturan Profil - SIMPAS DLH')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    {{-- Title Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Pengaturan Profil</h1>
            <p class="text-sm text-slate-500">Kelola informasi identitas, keamanan akun, dan akses Anda di SIMPAS DLH.</p>
        </div>
    </div>

    {{-- Global Notifications --}}
    @if (session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 text-emerald-800 text-sm font-medium border border-emerald-200 flex items-center gap-3 shadow-xs">
            <div class="h-8 w-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-circle-check text-lg"></i>
            </div>
            <div>
                <p class="font-semibold">Berhasil!</p>
                <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 rounded-xl bg-rose-50 text-rose-800 text-sm font-medium border border-rose-200 flex items-center gap-3 shadow-xs">
            <div class="h-8 w-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-circle-exclamation text-lg"></i>
            </div>
            <div>
                <p class="font-semibold">Terdapat Kesalahan Input</p>
                <p class="text-xs text-rose-700 mt-0.5">Mohon periksa kembali data yang Anda masukkan pada formulir di bawah.</p>
            </div>
        </div>
    @endif

    {{-- Profile Hero Card --}}
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-emerald-500/10 to-teal-500/5 rounded-full blur-2xl pointer-events-none"></div>

        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 relative z-10">
            {{-- Initial Avatar --}}
            <div class="h-20 w-20 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white font-bold text-3xl flex items-center justify-center shadow-md shadow-emerald-600/20 shrink-0 border-2 border-white">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            {{-- User Main Details --}}
            <div class="flex-1 text-center sm:text-left space-y-2">
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2.5">
                    <h2 class="text-xl font-bold text-slate-800">{{ $user->name }}</h2>

                    {{-- Role Badges --}}
                    @if ($user->hasRole('admin'))
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/80 shadow-xs">
                            <i class="fa-solid fa-user-shield text-xs"></i> Administrator
                        </span>
                    @elseif ($user->hasRole('driver'))
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200/80 shadow-xs">
                            <i class="fa-solid fa-truck-fast text-xs"></i> Driver Pengangkut
                        </span>
                    @elseif ($user->hasRole('kepala'))
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/80 shadow-xs">
                            <i class="fa-solid fa-user-tie text-xs"></i> Kepala Dinas
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200 shadow-xs">
                            <i class="fa-solid fa-user text-xs"></i> Pengguna
                        </span>
                    @endif

                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span> Akun Aktif
                    </span>
                </div>

                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4 text-xs text-slate-500 font-medium pt-1">
                    <span class="flex items-center gap-1.5">
                        <i class="fa-solid fa-envelope text-slate-400"></i>
                        {{ $user->email }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <i class="fa-solid fa-shield-halved text-slate-400"></i>
                        Akses Sistem Divalidasi
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Settings Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Card 1: Form Edit Informasi Profil --}}
        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 pb-4 mb-5 border-b border-slate-100">
                    <div class="h-10 w-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-id-card text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Informasi Pribadi</h3>
                        <p class="text-xs text-slate-500">Perbarui data identitas utama akun Anda.</p>
                    </div>
                </div>

                <form id="form-update-profile" method="post" action="{{ route('profile.update') }}" class="space-y-4">
                    @csrf
                    @method('put')

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-user text-sm"></i>
                            </span>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-800 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all @error('name') border-rose-500 @enderror">
                        </div>
                        @error('name')
                            <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-envelope text-sm"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-800 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all @error('email') border-rose-500 @enderror">
                        </div>
                        @error('email')
                            <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            </div>

            <div class="pt-6 mt-6 border-t border-slate-100 flex justify-end">
                <button type="submit" form="form-update-profile" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-5 py-2.5 rounded-xl text-sm transition-all shadow-xs flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk text-xs"></i> Simpan Profil
                </button>
            </div>
        </div>

        {{-- Card 2: Form Ubah Password --}}
        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 pb-4 mb-5 border-b border-slate-100">
                    <div class="h-10 w-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-lock text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Keamanan Akun</h3>
                        <p class="text-xs text-slate-500">Ubah kata sandi berkala untuk keamanan akun.</p>
                    </div>
                </div>

                <form id="form-update-password" method="post" action="{{ route('profile.password') }}" class="space-y-4">
                    @csrf
                    @method('put')

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kata Sandi Saat Ini</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-key text-sm"></i>
                            </span>
                            <input type="password" name="current_password" required placeholder="••••••••"
                                class="w-full border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-800 focus:border-slate-800 focus:ring-4 focus:ring-slate-800/10 transition-all @error('current_password') border-rose-500 @enderror">
                        </div>
                        @error('current_password')
                            <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kata Sandi Baru</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-lock text-sm"></i>
                            </span>
                            <input type="password" name="password" required placeholder="Minimal 8 karakter"
                                class="w-full border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-800 focus:border-slate-800 focus:ring-4 focus:ring-slate-800/10 transition-all @error('password') border-rose-500 @enderror">
                        </div>
                        @error('password')
                            <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Konfirmasi Kata Sandi Baru</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-check-double text-sm"></i>
                            </span>
                            <input type="password" name="password_confirmation" required placeholder="Ulangi kata sandi baru"
                                class="w-full border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-800 focus:border-slate-800 focus:ring-4 focus:ring-slate-800/10 transition-all">
                        </div>
                    </div>
                </form>
            </div>

            <div class="pt-6 mt-6 border-t border-slate-100 flex justify-end">
                <button type="submit" form="form-update-password" class="bg-slate-800 hover:bg-slate-900 text-white font-medium px-5 py-2.5 rounded-xl text-sm transition-all shadow-xs flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-xs"></i> Perbarui Password
                </button>
            </div>
        </div>

    </div>

    {{-- Driver Info Card (If logged-in user is connected to Driver) --}}
    @if ($user->driver)
        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6">
            <div class="flex items-center justify-between pb-4 mb-5 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-id-badge text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Biodata Resmi Driver</h3>
                        <p class="text-xs text-slate-500">Data resmi terdaftar pada database SIMPAS Dinas Lingkungan Hidup.</p>
                    </div>
                </div>
                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                    <i class="fa-solid fa-truck text-xs mr-1"></i> Driver Terverifikasi
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-slate-50/70 rounded-xl p-3.5 border border-slate-100">
                    <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block mb-1">Kode Driver</span>
                    <span class="text-sm font-bold text-slate-800">{{ $user->driver->kode_driver ?? '-' }}</span>
                </div>

                <div class="bg-slate-50/70 rounded-xl p-3.5 border border-slate-100">
                    <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block mb-1">NIK</span>
                    <span class="text-sm font-bold text-slate-800">{{ $user->driver->nik ?? '-' }}</span>
                </div>

                <div class="bg-slate-50/70 rounded-xl p-3.5 border border-slate-100">
                    <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block mb-1">No. HP / Whatsapp</span>
                    <span class="text-sm font-bold text-slate-800">{{ $user->driver->no_hp ?? '-' }}</span>
                </div>

                <div class="bg-slate-50/70 rounded-xl p-3.5 border border-slate-100">
                    <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block mb-1">Jenis Kelamin</span>
                    <span class="text-sm font-bold text-slate-800">
                        {{ isset($user->driver->jenis_kelamin) ? ($user->driver->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan') : '-' }}
                    </span>
                </div>

                <div class="bg-slate-50/70 rounded-xl p-3.5 border border-slate-100 md:col-span-2">
                    <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block mb-1">Alamat</span>
                    <span class="text-sm font-semibold text-slate-700">{{ $user->driver->alamat ?? '-' }}</span>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection