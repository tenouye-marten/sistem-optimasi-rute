@php

$driver = auth()->user()->driver ?? null;

$pengangkutanAktif = null;

if ($driver) {

    $pengangkutanAktif = \App\Models\Pengangkutan::where('driver_id', $driver->id)
        ->whereDate('tanggal', today())
        ->where('status', '!=', 'Selesai')
        ->first();

}

@endphp

<ul class="space-y-1 text-sm">

    {{-- ================= Dashboard ================= --}}
    <li>

        <a href="{{ route('driver.dashboard') }}"
            class="flex items-center px-4 py-3 rounded-lg transition
            {{ request()->routeIs('driver.dashboard')
                ? 'bg-green-600 text-white font-semibold'
                : 'text-gray-700 hover:bg-green-100 hover:text-green-700' }}">

            <i class="fas fa-gauge-high w-5"></i>

            <span class="ml-3">

                Dashboard

            </span>

        </a>

    </li>

    {{-- ================= Driver ================= --}}
    <li class="mt-6">

        <p class="px-4 mb-2 text-xs font-bold uppercase tracking-wider text-gray-400">

            Driver

        </p>

    </li>

    {{-- Rute Saya --}}
    <li>

        <a href="{{ route('driver.rute.index') }}"
            class="flex items-center px-4 py-3 rounded-lg transition
            {{ request()->routeIs('driver.rute.*')
                ? 'bg-green-600 text-white font-semibold'
                : 'text-gray-700 hover:bg-green-100 hover:text-green-700' }}">

            <i class="fas fa-route w-5"></i>

            <span class="ml-3">

                Rute Saya

            </span>

        </a>

    </li>

    {{-- Pengangkutan --}}
    @if($pengangkutanAktif)

        <li>

            <a href="{{ route('driver.pengangkutan.index') }}"
                class="flex items-center px-4 py-3 rounded-lg transition
                {{ request()->routeIs('driver.pengangkutan.index')
                    ? 'bg-green-600 text-white font-semibold'
                    : 'text-gray-700 hover:bg-green-100 hover:text-green-700' }}">

                <i class="fas fa-truck-moving w-5"></i>

                <span class="ml-3">

                    Pengangkutan

                </span>

            </a>

        </li>

        <li>

            <a href="{{ route('driver.pengangkutan.tps') }}"
                class="flex items-center px-4 py-3 rounded-lg transition
                {{ request()->routeIs('driver.pengangkutan.tps*')
                    ? 'bg-green-600 text-white font-semibold'
                    : 'text-gray-700 hover:bg-green-100 hover:text-green-700' }}">

                <i class="fas fa-map-marker-alt w-5"></i>

                <span class="ml-3">

                    TPS Aktif

                </span>

            </a>

        </li>

    @endif

    {{-- ================= Akun ================= --}}
    <li class="mt-6">

        <p class="px-4 mb-2 text-xs font-bold uppercase tracking-wider text-gray-400">

            Akun

        </p>

    </li>

    <li>

        <a href="{{ route('profile.edit') }}"
            class="flex items-center px-4 py-3 rounded-lg transition
            {{ request()->routeIs('profile.*')
                ? 'bg-green-600 text-white font-semibold'
                : 'text-gray-700 hover:bg-green-100 hover:text-green-700' }}">

            <i class="fas fa-user-circle w-5"></i>

            <span class="ml-3">

                Profil

            </span>

        </a>

    </li>

</ul>