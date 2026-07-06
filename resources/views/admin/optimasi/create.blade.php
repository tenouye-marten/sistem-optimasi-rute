@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Generate Optimasi Rute</h1>
            <p class="text-sm text-gray-500">Pilih driver, pool, dan TPA untuk menghitung rute terbaik.</p>
        </div>
        <a href="{{ route('admin.optimasi.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg text-sm transition">
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.optimasi.store') }}" method="POST">
        @csrf
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Tanggal --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Generate</label>
                    <input type="date" name="tanggal_generate" value="{{ date('Y-m-d') }}" 
                        class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                {{-- Driver --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Driver</label>
                    <select id="driver" name="driver_id" class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Driver --</option>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}">{{ $driver->kode_driver }} - {{ $driver->nama }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Pool --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pool</label>
                    <select name="pool_id" class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                        @foreach($pools as $pool)
                            <option value="{{ $pool->id }}">{{ $pool->nama_pool }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- TPA --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">TPA</label>
                    <select name="tpa_id" class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                        @foreach($tpas as $tpa)
                            <option value="{{ $tpa->id }}">{{ $tpa->nama_tpa }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Driver Info Section --}}
        <div id="driver-info" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8 mt-6 hidden">
            <h2 class="text-lg font-bold text-gray-800 mb-6">Informasi Wilayah Kerja Driver</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8 text-sm">
                @foreach(['Kendaraan' => 'kendaraan', 'Nomor Polisi' => 'nopol', 'Kapasitas' => 'kapasitas', 'Jumlah TPS' => 'jumlah_tps'] as $label => $id)
                    <div class="flex flex-col">
                        <span class="text-gray-500 font-medium">{{ $label }}</span>
                        <span id="{{ $id }}" class="font-semibold text-gray-900 mt-0.5">-</span>
                    </div>
                @endforeach
            </div>

            <div class="overflow-x-auto border border-gray-200 rounded-lg">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 border-b border-gray-200 text-gray-700 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">Kode</th>
                            <th class="px-4 py-3">Nama TPS</th>
                            <th class="px-4 py-3">Alamat</th>
                        </tr>
                    </thead>
                    <tbody id="list-tps" class="divide-y divide-gray-200"></tbody>
                </table>
            </div>
            
            <div class="flex justify-end mt-8">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-8 py-3 rounded-lg text-sm transition shadow-sm">
                    Generate Optimasi Sekarang
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const driver = document.getElementById('driver');
    driver.addEventListener('change', function(){
        if(this.value == '') {
            document.getElementById('driver-info').classList.add('hidden');
            return;
        }

        fetch('/admin/optimasi/driver/' + this.value)
        .then(res => res.json())
        .then(res => {
            if(!res.success) { alert(res.message); return; }
            
            document.getElementById('driver-info').classList.remove('hidden');
            document.getElementById('kendaraan').innerHTML = res.kendaraan.merk ?? res.kendaraan.nama_kendaraan;
            document.getElementById('nopol').innerHTML = res.kendaraan.nomor_polisi;
            document.getElementById('kapasitas').innerHTML = res.kendaraan.kapasitas + " Kg";
            document.getElementById('jumlah_tps').innerHTML = res.jumlah_tps;

            let html = res.tps.map(item => `
                <tr>
                    <td class="px-4 py-3 font-medium text-gray-900">${item.kode_tps}</td>
                    <td class="px-4 py-3">${item.nama_tps}</td>
                    <td class="px-4 py-3">${item.alamat}</td>
                </tr>
            `).join('');
            document.getElementById('list-tps').innerHTML = html;
        });
    });
</script>
@endpush