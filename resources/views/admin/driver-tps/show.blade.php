@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Wilayah Driver</h1>
            <p class="text-sm text-gray-500">Informasi lengkap wilayah kerja dan daftar TPS driver.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.driver-tps.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg text-sm transition">
                Kembali
            </a>
            <a href="{{ route('admin.driver-tps.edit', $driver->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg text-sm transition">
                Kelola Wilayah
            </a>
        </div>
    </div>

    {{-- Informasi Driver --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informasi Driver</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
            @php
                $driverInfo = [
                    'Kode Driver'    => $driver->kode_driver,
                    'Nama Driver'    => $driver->nama,
                    'Nomor HP'       => $driver->no_hp,
                    'Status'         => $driver->status,
                    'Jumlah TPS'     => $driver->tps->count() . ' TPS',
                    'Total Kapasitas'=> number_format($totalKapasitas) . ' Kg',
                ];
            @endphp

            @foreach($driverInfo as $label => $value)
                <div class="flex flex-col">
                    <span class="text-gray-500 font-medium">{{ $label }}</span>
                    @if($label === 'Status')
                        <span class="mt-1">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $value == 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $value }}
                            </span>
                        </span>
                    @else
                        <span class="font-semibold text-gray-900 mt-0.5">{{ $value }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    {{-- Daftar TPS --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800">Daftar TPS Wilayah Driver</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-center w-12">No</th>
                        <th class="px-6 py-3">Kode TPS</th>
                        <th class="px-6 py-3">Nama TPS</th>
                        <th class="px-6 py-3">Alamat</th>
                        <th class="px-6 py-3 text-center">Kapasitas</th>
                        <th class="px-6 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($driver->tps as $tps)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-3 text-center">{{ $loop->iteration }}</td>
                        <td class="px-6 py-3 font-medium text-gray-900">{{ $tps->kode_tps }}</td>
                        <td class="px-6 py-3">{{ $tps->nama_tps }}</td>
                        <td class="px-6 py-3">{{ $tps->alamat }}</td>
                        <td class="px-6 py-3 text-center">{{ number_format($tps->kapasitas) }} Kg</td>
                        <td class="px-6 py-3 text-center">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $tps->status == 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $tps->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                            Driver ini belum memiliki wilayah TPS.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection