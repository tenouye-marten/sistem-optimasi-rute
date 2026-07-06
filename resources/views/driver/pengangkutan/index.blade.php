@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div>

        <h1 class="text-3xl font-bold">

            Pengangkutan Hari Ini

        </h1>

        <p class="text-gray-500 mt-1">

            Informasi pengangkutan dan rute yang harus diselesaikan hari ini.

        </p>

    </div>

    {{-- Alert --}}
    @if(session('success'))

        <div class="bg-green-100 border border-green-300 text-green-700 p-4 rounded-lg">

            {{ session('success') }}

        </div>

    @endif

    @if(session('warning'))

        <div class="bg-yellow-100 border border-yellow-300 text-yellow-700 p-4 rounded-lg">

            {{ session('warning') }}

        </div>

    @endif

    @if(session('info'))

        <div class="bg-blue-100 border border-blue-300 text-blue-700 p-4 rounded-lg">

            {{ session('info') }}

        </div>

    @endif

    @if(!$pengangkutan)

        @php

            $optimasi = \App\Models\OptimasiRute::where('driver_id', $driver->id)
                ->whereDate('tanggal', today())
                ->first();

        @endphp

        <div class="bg-white rounded-xl shadow p-8 text-center">

            <h2 class="text-2xl font-semibold">

                Belum Ada Pengangkutan

            </h2>

            <p class="mt-2 text-gray-500">

                Tekan tombol di bawah untuk memulai pengangkutan hari ini.

            </p>

            @if($optimasi)

                <form
                    action="{{ route('driver.pengangkutan.mulai', $optimasi) }}"
                    method="POST"
                    class="mt-6">

                    @csrf

                    <button
                        type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg">

                        Mulai Pengangkutan

                    </button>

                </form>

            @else

                <p class="mt-6 text-red-600">

                    Belum ada rute yang diberikan kepada Anda.

                </p>

            @endif

        </div>

    @else

        {{-- Statistik --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

            <div class="bg-white rounded-xl shadow p-5">

                <p class="text-sm text-gray-500">

                    Status

                </p>

                <h3 class="mt-2 text-xl font-bold text-green-600">

                    {{ $pengangkutan->status }}

                </h3>

            </div>

            <div class="bg-white rounded-xl shadow p-5">

                <p class="text-sm text-gray-500">

                    Status Perjalanan

                </p>

                <h3 class="mt-2 text-xl font-bold text-blue-600">

                    {{ $pengangkutan->status_perjalanan }}

                </h3>

            </div>

            <div class="bg-white rounded-xl shadow p-5">

                <p class="text-sm text-gray-500">

                    Muatan Kendaraan

                </p>

                <h3 class="mt-2 text-xl font-bold text-orange-600">

                    {{ number_format($pengangkutan->muatan_sekarang,0,',','.') }}

                    /

                    {{ number_format($pengangkutan->kapasitas_kendaraan,0,',','.') }}

                    Kg

                </h3>

            </div>

            <div class="bg-white rounded-xl shadow p-5">

                <p class="text-sm text-gray-500">

                    TPS Selesai

                </p>

                <h3 class="mt-2 text-xl font-bold text-indigo-600">

                    {{ $pengangkutan->details->where('status','Selesai')->count() }}

                    /

                    {{ $pengangkutan->details->count() }}

                </h3>

            </div>

        </div>

        {{-- Informasi Rute --}}
        <div class="bg-white rounded-xl shadow">

            <div class="border-b px-6 py-4">

                <h2 class="font-semibold text-lg">

                    Informasi Rute

                </h2>

            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>

                    <p class="text-sm text-gray-500">

                        Pool

                    </p>

                    <p class="font-semibold">

                        {{ $pengangkutan->optimasi->pool->nama }}

                    </p>

                </div>

                <div>

                    <p class="text-sm text-gray-500">

                        TPA

                    </p>

                    <p class="font-semibold">

                        {{ $pengangkutan->optimasi->tpa->nama }}

                    </p>

                </div>

                <div>

                    <p class="text-sm text-gray-500">

                        Tanggal

                    </p>

                    <p>

                        {{ $pengangkutan->tanggal }}

                    </p>

                </div>

                <div>

                    <p class="text-sm text-gray-500">

                        Waktu Mulai

                    </p>

                    <p>

                        {{ optional($pengangkutan->waktu_mulai)->format('H:i') }}

                    </p>

                </div>

            </div>

        </div>

        {{-- Tombol --}}
        <div class="flex justify-end">

            @if($pengangkutan->status == 'Selesai')

                <span class="bg-green-100 text-green-700 px-6 py-3 rounded-lg">

                    Pengangkutan Hari Ini Telah Selesai

                </span>

            @elseif($pengangkutan->status_perjalanan == 'Menuju TPA')

                <a
                    href="{{ route('driver.pengangkutan.tpa') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

                    Menuju TPA

                </a>

            @else

                <a
                    href="{{ route('driver.pengangkutan.tps') }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg">

                    Lanjut Pengangkutan

                </a>

            @endif

        </div>

    @endif

</div>

@endsection