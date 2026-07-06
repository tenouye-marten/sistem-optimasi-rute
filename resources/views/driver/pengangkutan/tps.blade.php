@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div>

        <h1 class="text-3xl font-bold">

            TPS Aktif

        </h1>

        <p class="mt-1 text-gray-500">

            Lakukan pengangkutan sesuai urutan rute yang telah dioptimasi.

        </p>

    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

        <div class="bg-white rounded-xl shadow p-5">

            <p class="text-sm text-gray-500">

                TPS Saat Ini

            </p>

            <h3 class="mt-2 text-2xl font-bold text-indigo-600">

                {{ $tpsAktif->urutan }}

            </h3>

        </div>

        <div class="bg-white rounded-xl shadow p-5">

            <p class="text-sm text-gray-500">

                Status

            </p>

            <h3 class="mt-2 text-xl font-bold text-green-600">

                {{ $tpsAktif->status }}

            </h3>

        </div>

        <div class="bg-white rounded-xl shadow p-5">

            <p class="text-sm text-gray-500">

                Muatan Truk

            </p>

            <h3 class="mt-2 text-xl font-bold text-blue-600">

                {{ number_format($pengangkutan->muatan_sekarang,0,',','.') }}

                Kg

            </h3>

        </div>

        <div class="bg-white rounded-xl shadow p-5">

            <p class="text-sm text-gray-500">

                Kapasitas Truk

            </p>

            <h3 class="mt-2 text-xl font-bold text-orange-600">

                {{ number_format($pengangkutan->kapasitas_kendaraan,0,',','.') }}

                Kg

            </h3>

        </div>

    </div>

    {{-- Informasi TPS --}}
    <div class="bg-white rounded-xl shadow">

        <div class="border-b px-6 py-4">

            <h2 class="text-lg font-semibold">

                Informasi TPS

            </h2>

        </div>

        <div class="p-6 space-y-5">

            <div>

                <p class="text-sm text-gray-500">

                    Nama TPS

                </p>

                <p class="font-semibold">

                    {{ $tpsAktif->tps->nama_tps }}

                </p>

            </div>

            <div>

                <p class="text-sm text-gray-500">

                    Alamat

                </p>

                <p>

                    {{ $tpsAktif->tps->alamat }}

                </p>

            </div>

            @if($tpsAktif->status == 'Proses')

                <div>

                    <p class="text-sm text-gray-500">

                        Volume Tersisa

                    </p>

                    <p class="font-semibold text-red-600">

                        {{ number_format($tpsAktif->volume_sisa,0,',','.') }}

                        Kg

                    </p>

                </div>

            @endif

        </div>

    </div>

    {{-- Tombol --}}
    <div class="flex justify-end">

        <a
           href="{{ route('driver.pengangkutan.tps.show', $tpsAktif) }}"
            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg">

            Mulai Pengangkutan TPS

        </a>

    </div>

</div>

@endsection