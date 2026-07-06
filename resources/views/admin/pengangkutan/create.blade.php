@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">

        <div>

            <h1 class="text-3xl font-bold">
                Generate Optimasi Rute
            </h1>

            <p class="text-gray-500">
                Pilih driver untuk membuat optimasi rute pengangkutan.
            </p>

        </div>

        <a href="{{ route('admin.pengangkutan.index') }}"
            class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">

            Kembali

        </a>

    </div>

    <div class="bg-white rounded-xl shadow p-6">

        <form action="{{ route('admin.pengangkutan.store') }}" method="POST">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Tanggal --}}
                <div>

                    <label class="block mb-2 font-semibold">

                        Tanggal

                    </label>

                    <input
                        type="date"
                        name="tanggal"
                        value="{{ old('tanggal', date('Y-m-d')) }}"
                        class="w-full border rounded-lg px-4 py-2">

                    @error('tanggal')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror

                </div>

                {{-- Driver --}}
                <div>

                    <label class="block mb-2 font-semibold">

                        Driver

                    </label>

                    <select
                        id="driver_id"
                        name="driver_id"
                        class="w-full border rounded-lg px-4 py-2">

                        <option value="">-- Pilih Driver --</option>

                        @foreach($drivers as $driver)

                            <option value="{{ $driver->id }}">

                                {{ $driver->kode_driver }}

                                -

                                {{ $driver->nama }}

                            </option>

                        @endforeach

                    </select>

                    @error('driver_id')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror

                </div>

                {{-- Pool --}}
                <div>

                    <label class="block mb-2 font-semibold">

                        Pool

                    </label>

                    <select
                        name="pool_id"
                        class="w-full border rounded-lg px-4 py-2">

                        <option value="">-- Pilih Pool --</option>

                        @foreach($pools as $pool)

                            <option value="{{ $pool->id }}">

                                {{ $pool->nama_pool }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- TPA --}}
                <div>

                    <label class="block mb-2 font-semibold">

                        TPA

                    </label>

                    <select
                        name="tpa_id"
                        class="w-full border rounded-lg px-4 py-2">

                        <option value="">-- Pilih TPA --</option>

                        @foreach($tpas as $tpa)

                            <option value="{{ $tpa->id }}">

                                {{ $tpa->nama_tpa }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

            {{-- Informasi Driver --}}
            <div
                id="driverCard"
                class="hidden mt-8 bg-gray-50 border rounded-xl p-6">

                <h3 class="text-lg font-bold mb-4">

                    Informasi Driver

                </h3>

                <div class="grid grid-cols-2 gap-4">

                    <div>

                        <label class="font-semibold">

                            Nama Driver

                        </label>

                        <p id="driverNama">-</p>

                    </div>

                    <div>

                        <label class="font-semibold">

                            Kendaraan

                        </label>

                        <p id="kendaraanNama">-</p>

                    </div>

                    <div>

                        <label class="font-semibold">

                            Nomor Polisi

                        </label>

                        <p id="nomorPolisi">-</p>

                    </div>

                    <div>

                        <label class="font-semibold">

                            Kapasitas

                        </label>

                        <p id="kapasitas">-</p>

                    </div>

                </div>

            </div>

            {{-- Daftar TPS --}}
            <div
                id="tpsCard"
                class="hidden mt-6 bg-white border rounded-xl p-6">

                <h3 class="text-lg font-bold mb-4">

                    TPS Wilayah Driver

                </h3>

                <table class="w-full border">

                    <thead class="bg-gray-100">

                        <tr>

                            <th class="border p-2 w-16">No</th>

                            <th class="border p-2">Kode</th>

                            <th class="border p-2">Nama TPS</th>

                            <th class="border p-2">Alamat</th>

                        </tr>

                    </thead>

                    <tbody id="listTPS">

                    </tbody>

                </table>

            </div>

            <div class="mt-8 flex justify-end gap-3">

                <a
                    href="{{ route('admin.pengangkutan.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">

                    Batal

                </a>

                <button
                    type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">

                    Generate Optimasi

                </button>

            </div>

        </form>

    </div>

</div>

@endsection

@push('scripts')

<script>

const driverSelect=document.getElementById('driver_id');

driverSelect.addEventListener('change',function(){

    let id=this.value;

    if(id==''){

        document.getElementById('driverCard').classList.add('hidden');

        document.getElementById('tpsCard').classList.add('hidden');

        return;

    }

    fetch('/admin/pengangkutan/driver/'+id)

    .then(res=>res.json())

    .then(data=>{

        document.getElementById('driverCard').classList.remove('hidden');

        document.getElementById('tpsCard').classList.remove('hidden');

        document.getElementById('driverNama').innerHTML=data.nama;

        document.getElementById('kendaraanNama').innerHTML=data.kendaraan.nama_kendaraan;

        document.getElementById('nomorPolisi').innerHTML=data.kendaraan.nomor_polisi;

        document.getElementById('kapasitas').innerHTML=data.kendaraan.kapasitas+' Kg';

        let html='';

        data.tps.forEach((item,index)=>{

            html+=`
                <tr>

                    <td class="border p-2 text-center">${index+1}</td>

                    <td class="border p-2">${item.kode_tps}</td>

                    <td class="border p-2">${item.nama_tps}</td>

                    <td class="border p-2">${item.alamat}</td>

                </tr>
            `;

        });

        document.getElementById('listTPS').innerHTML=html;

    });

});

</script>

@endpush