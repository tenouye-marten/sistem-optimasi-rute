@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">

        <div>

            <h1 class="text-3xl font-bold">

                Optimasi Rute

            </h1>

            <p class="text-gray-500">

                Kelola hasil optimasi rute pengangkutan sampah.

            </p>

        </div>

        <a
            href="{{ route('admin.pengangkutan.create') }}"
            class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">

            + Generate Optimasi

        </a>

    </div>

    {{-- Flash Message --}}
    @if(session('success'))

        <div
            class="bg-green-100 border border-green-300 text-green-700 p-4 rounded">

            {{ session('success') }}

        </div>

    @endif

    {{-- Search --}}
    <form
        method="GET"
        action="{{ route('admin.pengangkutan.index') }}">

        <div class="flex gap-3">

            <input

                type="text"

                name="search"

                value="{{ $search }}"

                placeholder="Cari kode atau driver..."

                class="border rounded-lg px-4 py-2 w-80">

            <button
                class="bg-blue-600 text-white px-5 rounded-lg">

                Cari

            </button>

        </div>

    </form>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-100">

            <tr>

                <th class="p-3">No</th>

                <th>Kode</th>

                <th>Tanggal</th>

                <th>Driver</th>

                <th>Kendaraan</th>

                <th>Status</th>

                <th width="220">Aksi</th>

            </tr>

            </thead>

            <tbody>

            @forelse($pengangkutans as $item)

            <tr class="border-t">

                <td class="text-center">

                    {{ $pengangkutans->firstItem() + $loop->index }}

                </td>

                <td>

                    {{ $item->kode_pengangkutan }}

                </td>

                <td>

                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}

                </td>

                <td>

                    {{ $item->driver->nama }}

                </td>

                <td>

                    {{ $item->kendaraan->nama_kendaraan }}

                </td>

                <td>

                    @switch($item->status)

                        @case('Belum Berangkat')

                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">

                                Belum Berangkat

                            </span>

                        @break

                        @case('Sedang Berjalan')

                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">

                                Sedang Berjalan

                            </span>

                        @break

                        @case('Ditunda')

                            <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm">

                                Ditunda

                            </span>

                        @break

                        @default

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

                                Selesai

                            </span>

                    @endswitch

                </td>

                <td>

                    <div class="flex gap-2">

                        <a
                            href="{{ route('admin.pengangkutan.show',$item->id) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">

                            Detail

                        </a>

                        <form
                            action="{{ route('admin.pengangkutan.destroy',$item->id) }}"
                            method="POST"
                            onsubmit="return confirm('Hapus data optimasi ini?')">

                            @csrf
                            @method('DELETE')

                            <button
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">

                                Hapus

                            </button>

                        </form>

                    </div>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="7"
                    class="text-center py-10 text-gray-400">

                    Belum ada data optimasi rute.

                </td>

            </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    {{-- Pagination --}}
    <div>

        {{ $pengangkutans->links() }}

    </div>

</div>

@endsection