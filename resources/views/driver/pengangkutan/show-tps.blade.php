@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div>

        <h1 class="text-3xl font-bold">

            Pengangkutan TPS

        </h1>

        <p class="text-gray-500 mt-1">

            Input volume sampah yang berhasil diangkut pada TPS.

        </p>

    </div>

    {{-- Informasi Pengangkutan --}}
    <div class="bg-white rounded-xl shadow">

        <div class="border-b px-6 py-4">

            <h2 class="text-lg font-semibold">

                Informasi TPS

            </h2>

        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>

                <p class="text-sm text-gray-500">

                    Nama TPS

                </p>

                <p class="font-semibold">

                    {{ $detail->tps->nama_tps }}

                </p>

            </div>

            <div>

                <p class="text-sm text-gray-500">

                    Urutan

                </p>

                <p class="font-semibold">

                    TPS {{ $detail->urutan }}

                </p>

            </div>

            <div>

                <p class="text-sm text-gray-500">

                    Muatan Kendaraan

                </p>

                <p class="font-semibold text-blue-600">

                    {{ number_format($detail->pengangkutan->muatan_sekarang,0,',','.') }}
                    /
                    {{ number_format($detail->pengangkutan->kapasitas_kendaraan,0,',','.') }}
                    Kg

                </p>

            </div>

            <div>

                <p class="text-sm text-gray-500">

                    Status TPS

                </p>

                <span
                    class="inline-block px-3 py-1 rounded-full text-sm

                    @if($detail->status=='Selesai')
                        bg-green-100 text-green-700
                    @elseif($detail->status=='Proses')
                        bg-yellow-100 text-yellow-700
                    @else
                        bg-gray-100 text-gray-700
                    @endif">

                    {{ $detail->status }}

                </span>

            </div>

        </div>

    </div>

    {{-- Form --}}
    <div class="bg-white rounded-xl shadow">

        <div class="border-b px-6 py-4">

            <h2 class="text-lg font-semibold">

                Input Volume Sampah

            </h2>

        </div>

        <form
            action="{{ route('driver.pengangkutan.tps.update', $detail) }}"
            method="POST"
            class="p-6 space-y-6">

            @csrf
            @method('PATCH')

            <div>

                <label class="block mb-2 font-medium">

                    Volume Sampah (Kg)

                </label>

                <input
                    type="number"
                    name="volume"
                    step="0.01"
                    min="0.01"
                    value="{{ old('volume', $volumeInput) }}"
                    class="w-full border rounded-lg px-4 py-3"
                    required>

                @error('volume')

                    <small class="text-red-600">

                        {{ $message }}

                    </small>

                @enderror

            </div>

            @if($detail->status == 'Proses')

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">

                    <p class="text-yellow-700">

                        Volume sampah yang masih tersisa di TPS:

                        <strong>

                            {{ number_format($detail->volume_sisa,0,',','.') }}
                            Kg

                        </strong>

                    </p>

                </div>

            @endif

            <div class="flex justify-end gap-3">

                <a
                    href="{{ route('driver.pengangkutan.tps') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">

                    Kembali

                </a>

                <button
                    type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection