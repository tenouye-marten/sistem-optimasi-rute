@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div>

        <h1 class="text-3xl font-bold">

            Tempat Pembuangan Akhir (TPA)

        </h1>

        <p class="mt-1 text-gray-500">

            Buang muatan kendaraan sebelum melanjutkan pengangkutan.

        </p>

    </div>

    {{-- Alert --}}
    @if(session('warning'))

        <div class="bg-yellow-100 border border-yellow-300 text-yellow-700 p-4 rounded-lg">

            {{ session('warning') }}

        </div>

    @endif

    {{-- Informasi Pengangkutan --}}
    <div class="bg-white rounded-xl shadow">

        <div class="border-b px-6 py-4">

            <h2 class="text-lg font-semibold">

                Informasi TPA

            </h2>

        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>

                <p class="text-sm text-gray-500">

                    Nama TPA

                </p>

                <p class="font-semibold">

                    {{ $pengangkutan->optimasi->tpa->nama_tpa }}

                </p>

            </div>

            <div>

                <p class="text-sm text-gray-500">

                    Status Perjalanan

                </p>

                <span
                    class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-700">

                    {{ $pengangkutan->status_perjalanan }}

                </span>

            </div>

            <div>

                <p class="text-sm text-gray-500">

                    Muatan Kendaraan

                </p>

                <p class="font-semibold text-green-600">

                    {{ number_format($pengangkutan->muatan_sekarang,0,',','.') }}

                    /

                    {{ number_format($pengangkutan->kapasitas_kendaraan,0,',','.') }}

                    Kg

                </p>

            </div>

            <div>

                <p class="text-sm text-gray-500">

                    Tanggal

                </p>

                <p>

                    {{ \Carbon\Carbon::parse($pengangkutan->tanggal)->format('d F Y') }}

                </p>

            </div>

        </div>

    </div>

    {{-- Informasi --}}
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-5">

        <p class="text-blue-700">

            Setelah seluruh sampah dibuang di TPA, tekan tombol
            <strong>Konfirmasi Sampai TPA</strong>
            untuk melanjutkan proses pengangkutan.

        </p>

    </div>

    {{-- Tombol --}}
    <form
        action="{{ route('driver.pengangkutan.tpa.konfirmasi') }}"
        method="POST">

        @csrf
        @method('PATCH')

        <div class="flex justify-end gap-3">

            <a
                href="{{ route('driver.pengangkutan.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">

                Kembali

            </a>

            <button
                type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg">

                Konfirmasi Sampai TPA

            </button>

        </div>

    </form>

</div>

@endsection