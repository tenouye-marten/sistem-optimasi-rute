@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-3xl font-bold">
                Tambah Pool
            </h1>

            <p class="text-gray-500">
                Tambahkan data Pool baru.
            </p>
        </div>

        <a href="{{ route('admin.pool.index') }}"
            class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">

            Kembali

        </a>

    </div>

    <div class="bg-white shadow rounded-xl p-6">

        <form action="{{ route('admin.pool.store') }}" method="POST">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nama Pool --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Nama Pool
                    </label>

                    <input
                        type="text"
                        name="nama_pool"
                        value="{{ old('nama_pool') }}"
                        class="w-full border rounded-lg px-4 py-2"
                        placeholder="Masukkan nama pool">

                    @error('nama_pool')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror

                </div>

                {{-- Status --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Status
                    </label>

                    <select
                        name="status"
                        class="w-full border rounded-lg px-4 py-2">

                        <option value="">-- Pilih Status --</option>

                        <option value="Aktif"
                            {{ old('status')=='Aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="Tidak Aktif"
                            {{ old('status')=='Tidak Aktif' ? 'selected' : '' }}>
                            Tidak Aktif
                        </option>

                    </select>

                    @error('status')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror

                </div>

                {{-- Latitude --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Latitude
                    </label>

                    <input
                        type="text"
                        name="latitude"
                        value="{{ old('latitude') }}"
                        class="w-full border rounded-lg px-4 py-2"
                        placeholder="-2.533710">

                    @error('latitude')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror

                </div>

                {{-- Longitude --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Longitude
                    </label>

                    <input
                        type="text"
                        name="longitude"
                        value="{{ old('longitude') }}"
                        class="w-full border rounded-lg px-4 py-2"
                        placeholder="140.718130">

                    @error('longitude')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror

                </div>

            </div>

            {{-- Alamat --}}
            <div class="mt-6">

                <label class="block mb-2 font-medium">
                    Alamat
                </label>

                <textarea
                    name="alamat"
                    rows="4"
                    class="w-full border rounded-lg px-4 py-2"
                    placeholder="Masukkan alamat pool">{{ old('alamat') }}</textarea>

                @error('alamat')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror

            </div>

            <div class="mt-8 flex gap-3">

                <button
                    type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg">

                    Simpan

                </button>

                <a href="{{ route('admin.pool.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">

                    Batal

                </a>

            </div>

        </form>

    </div>

</div>

@endsection