@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <div>

        <h1 class="text-3xl font-bold">

            Dashboard Admin

        </h1>

        <p class="text-gray-500">

            Selamat datang,
            {{ auth()->user()->name }}

        </p>

    </div>

    {{-- Statistik --}}

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

        @php

            $cards = [

                ['Driver',$totalDriver,'bg-blue-500'],

                ['Kendaraan',$totalKendaraan,'bg-green-500'],

                ['TPS',$totalTPS,'bg-yellow-500'],

                ['TPA',$totalTPA,'bg-red-500'],

                ['Pool',$totalPool,'bg-indigo-500'],

                ['Optimasi',$totalOptimasi,'bg-purple-500'],

                ['Pengangkutan',$totalPengangkutan,'bg-cyan-500'],

                ['Sampah',$totalSampah.' Kg','bg-orange-500'],

            ];

        @endphp

        @foreach($cards as $card)

        <div class="rounded-xl shadow bg-white p-5">

            <div class="text-gray-500">

                {{ $card[0] }}

            </div>

            <div class="mt-3 text-3xl font-bold">

                {{ $card[1] }}

            </div>

            <div class="mt-4 h-2 rounded {{ $card[2] }}"></div>

        </div>

        @endforeach

    </div>

    <div class="grid lg:grid-cols-2 gap-6">

        {{-- Pengangkutan --}}

        <div class="bg-white rounded-xl shadow">

            <div class="border-b p-4 font-semibold">

                Pengangkutan Terbaru

            </div>

            <table class="w-full text-sm">

                <thead>

                    <tr class="bg-gray-100">

                        <th class="p-3">Kode</th>

                        <th>Driver</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($pengangkutanTerbaru as $item)

                    <tr class="border-t">

                        <td class="p-3">

                            {{ $item->id }}

                        </td>

                        <td>

                            {{ $item->driver->nama }}

                        </td>

                        <td>

                            {{ $item->status }}

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="3" class="text-center py-6">

                            Belum ada data.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Optimasi --}}

        <div class="bg-white rounded-xl shadow">

            <div class="border-b p-4 font-semibold">

                Optimasi Terbaru

            </div>

            <table class="w-full text-sm">

                <thead>

                    <tr class="bg-gray-100">

                        <th class="p-3">Kode</th>

                        <th>Driver</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($optimasiTerbaru as $item)

                    <tr class="border-t">

                        <td class="p-3">

                            {{ $item->kode_optimasi }}

                        </td>

                        <td>

                            {{ $item->driver->nama }}

                        </td>

                        <td>

                            {{ $item->status }}

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="3" class="text-center py-6">

                            Belum ada data.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection