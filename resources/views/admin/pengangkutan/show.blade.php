@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">

    <div class="flex justify-between items-center">

        <div>

            <h1 class="text-3xl font-bold">

                Detail Pengangkutan

            </h1>

            <p class="text-gray-500">

                Informasi hasil optimasi rute pengangkutan.

            </p>

        </div>

        <a href="{{ route('admin.pengangkutan.index') }}"
            class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">

            Kembali

        </a>

    </div>

    {{-- Informasi Pengangkutan --}}
    <div class="bg-white rounded-xl shadow p-6">

        <table class="w-full">

            <tbody>

                <tr class="border-b">

                    <td class="py-3 font-semibold w-60">

                        Kode Pengangkutan

                    </td>

                    <td>

                        {{ $pengangkutan->kode_pengangkutan }}

                    </td>

                </tr>

                <tr class="border-b">

                    <td class="py-3 font-semibold">

                        Tanggal

                    </td>

                    <td>

                        {{ \Carbon\Carbon::parse($pengangkutan->tanggal)->format('d F Y') }}

                    </td>

                </tr>

                <tr class="border-b">

                    <td class="py-3 font-semibold">

                        Driver

                    </td>

                    <td>

                        {{ $pengangkutan->driver->nama }}

                    </td>

                </tr>

                <tr class="border-b">

                    <td class="py-3 font-semibold">

                        Kendaraan

                    </td>

                    <td>

                        {{ $pengangkutan->kendaraan->nama_kendaraan }}

                    </td>

                </tr>

                <tr class="border-b">

                    <td class="py-3 font-semibold">

                        Pool

                    </td>

                    <td>

                        {{ $pengangkutan->pool->nama_pool }}

                    </td>

                </tr>

                <tr class="border-b">

                    <td class="py-3 font-semibold">

                        TPA

                    </td>

                    <td>

                        {{ $pengangkutan->tpa->nama_tpa }}

                    </td>

                </tr>

                <tr class="border-b">

                    <td class="py-3 font-semibold">

                        Total Jarak

                    </td>

                    <td>

                        {{ number_format($pengangkutan->total_jarak,2) }} Km

                    </td>

                </tr>

                <tr class="border-b">

                    <td class="py-3 font-semibold">

                        Estimasi Waktu

                    </td>

                    <td>

                        {{ $pengangkutan->estimasi_waktu }} Menit

                    </td>

                </tr>

                <tr>

                    <td class="py-3 font-semibold">

                        Status

                    </td>

                    <td>

                        @switch($pengangkutan->status)

                            @case('Belum Berangkat')

                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">

                                    Belum Berangkat

                                </span>

                            @break

                            @case('Sedang Berjalan')

                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full">

                                    Sedang Berjalan

                                </span>

                            @break

                            @case('Ditunda')

                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full">

                                    Ditunda

                                </span>

                            @break

                            @default

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

                                    Selesai

                                </span>

                        @endswitch

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

    {{-- Detail TPS --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="p-6 border-b">

            <h2 class="text-xl font-semibold">

                Hasil Optimasi Rute

            </h2>

        </div>

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-3">No</th>

                    <th>TPS</th>

                    <th>Jarak</th>

                    <th>Estimasi</th>

                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

                @forelse($pengangkutan->detailTps as $detail)

                <tr class="border-t">

                    <td class="text-center">

                        {{ $detail->urutan }}

                    </td>

                    <td>

                        {{ $detail->tps->nama_tps }}

                    </td>

                    <td>

                        {{ number_format($detail->jarak,2) }} Km

                    </td>

                    <td>

                        {{ $detail->estimasi_waktu }} Menit

                    </td>

                    <td>

                        @if($detail->status=='Belum')

                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">

                                Belum

                            </span>

                        @else

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

                                Selesai

                            </span>

                        @endif

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5"
                        class="text-center py-10 text-gray-400">

                        Belum ada hasil optimasi.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection