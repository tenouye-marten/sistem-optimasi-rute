@extends('layouts.app')

@section('title', 'Tambah Driver - SIMPAS DLH')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Tambah Driver Baru</h1>
            <p class="text-sm text-slate-500 mt-1">Lengkapi informasi driver untuk dimasukkan ke sistem operasional.</p>
        </div>
        <a href="{{ route('admin.driver.index') }}" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium px-4 py-2 text-sm rounded-xl transition-all">
            <i class="fas fa-arrow-left text-xs"></i>
            <span>Kembali</span>
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white shadow-xs border border-slate-200/80 rounded-2xl p-6 sm:p-8">
        <form action="{{ route('admin.driver.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Kode Driver --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Kode Driver</label>
                    <input type="text" value="Otomatis dibuat oleh sistem" readonly class="w-full border border-slate-200 bg-slate-50 text-slate-400 rounded-xl px-4 py-2.5 text-sm font-medium">
                </div>

                {{-- Nama Driver --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Nama Driver <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap driver" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 shadow-xs transition-all @error('nama') border-rose-500 @enderror">
                    @error('nama') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                {{-- NIK --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">NIK <span class="text-rose-500">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik') }}" maxlength="20" placeholder="Masukkan NIK 16 digit" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 shadow-xs transition-all @error('nik') border-rose-500 @enderror">
                    @error('nik') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                {{-- Nomor HP --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Nomor HP / WhatsApp <span class="text-rose-500">*</span></label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 shadow-xs transition-all @error('no_hp') border-rose-500 @enderror">
                    @error('no_hp') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                {{-- Jenis Kelamin --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 shadow-xs transition-all">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Status Status Operasional</label>
                    <select name="status" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 shadow-xs transition-all">
                        <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('status') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Alamat --}}
            <div class="mt-6">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Alamat Tempat Tinggal</label>
                <textarea name="alamat" rows="3" placeholder="Masukkan alamat lengkap driver" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 shadow-xs transition-all">{{ old('alamat') }}</textarea>
                @error('alamat') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
            </div>

            {{-- Form Footer Actions --}}
            <div class="mt-8 flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.driver.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 transition-all">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-6 py-2.5 rounded-xl text-sm shadow-xs transition-all hover:shadow-sm">
                    <i class="fas fa-save"></i>
                    <span>Simpan Driver</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection