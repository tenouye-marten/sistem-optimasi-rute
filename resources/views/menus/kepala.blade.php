<ul class="space-y-1 text-sm">
    @php
        $activeClass = 'bg-green-600 text-white font-semibold shadow-md';
        $inactiveClass = 'text-gray-700 hover:bg-green-50 hover:text-green-700';
    @endphp

    {{-- Dashboard --}}
    <li>
        <a href="{{ route('kepala.dashboard') }}" 
           class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('kepala.dashboard') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-gauge-high w-5"></i>
            <span class="ml-3 font-medium">Dashboard</span>
        </a>
    </li>

    {{-- Monitoring --}}
    <li class="pt-6 pb-2 px-4 text-xs font-bold uppercase tracking-wider text-gray-400">Monitoring</li>
    <li>
        <a href="{{ route('kepala.monitoring.index') }}" 
           class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('kepala.monitoring.*') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-desktop w-5"></i>
            <span class="ml-3 font-medium">Monitoring Pengangkutan</span>
        </a>
    </li>

    {{-- Laporan --}}
    <li class="pt-6 pb-2 px-4 text-xs font-bold uppercase tracking-wider text-gray-400">Laporan</li>
    <li>
        <a href="{{ route('kepala.laporan.index') }}" 
           class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('kepala.laporan.*') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-file-lines w-5"></i>
            <span class="ml-3 font-medium">Laporan Pengangkutan</span>
        </a>
    </li>

    {{-- Akun --}}
    <li class="pt-6 pb-2 px-4 text-xs font-bold uppercase tracking-wider text-gray-400">Akun</li>
    <li>
        <a href="{{ route('profile.edit') }}" 
           class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('profile.*') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-user-circle w-5"></i>
            <span class="ml-3 font-medium">Profil</span>
        </a>
    </li>
</ul>