<ul class="space-y-1 text-sm">
    @php
        $activeClass = 'bg-green-600 text-white font-semibold shadow-md';
        $inactiveClass = 'text-gray-700 hover:bg-green-50 hover:text-green-700';
    @endphp

    {{-- Dashboard --}}
    <li>
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-gauge-high w-5"></i>
            <span class="ml-3 font-medium">Dashboard</span>
        </a>
    </li>

    {{-- Master Data --}}
    <li class="pt-6 pb-2 px-4 text-xs font-bold uppercase tracking-wider text-gray-400">Master Data</li>
    
    @foreach([
        'admin.driver.*' => ['route' => 'admin.driver.index', 'icon' => 'fa-user-tie', 'label' => 'Driver'],
        'admin.kendaraan.*' => ['route' => 'admin.kendaraan.index', 'icon' => 'fa-truck', 'label' => 'Kendaraan'],
        'admin.pool.*' => ['route' => 'admin.pool.index', 'icon' => 'fa-warehouse', 'label' => 'Pool'],
        'admin.tps.*' => ['route' => 'admin.tps.index', 'icon' => 'fa-dumpster', 'label' => 'TPS'],
        'admin.tpa.*' => ['route' => 'admin.tpa.index', 'icon' => 'fa-recycle', 'label' => 'TPA'],
        'admin.driver-tps.*' => ['route' => 'admin.driver-tps.index', 'icon' => 'fa-map-location-dot', 'label' => 'Wilayah Driver'],
    ] as $pattern => $item)
        <li>
            <a href="{{ route($item['route']) }}" 
               class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs($pattern) ? $activeClass : $inactiveClass }}">
                <i class="fas {{ $item['icon'] }} w-5"></i>
                <span class="ml-3 font-medium">{{ $item['label'] }}</span>
            </a>
        </li>
    @endforeach

    {{-- Operasional --}}
    <li class="pt-6 pb-2 px-4 text-xs font-bold uppercase tracking-wider text-gray-400">Operasional</li>
    
    <li>
        <a href="{{ route('admin.optimasi.index') }}" 
           class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.optimasi.*') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-route w-5"></i>
            <span class="ml-3 font-medium">Optimasi Rute</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.monitoring.index') }}" 
           class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.monitoring.*') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-desktop w-5"></i>
            <span class="ml-3 font-medium">Monitoring</span>
        </a>
    </li>

    {{-- Laporan --}}
    <li class="pt-6 pb-2 px-4 text-xs font-bold uppercase tracking-wider text-gray-400">Laporan</li>
    <li>
        <a href="{{ route('admin.laporan.index') }}" 
           class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.laporan.*') ? $activeClass : $inactiveClass }}">
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