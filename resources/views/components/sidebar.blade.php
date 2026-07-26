<aside
    id="sidebar"
    class="fixed top-16 left-0
           w-64
           h-[calc(100vh-4rem)]
           bg-white
           border-r border-gray-200
           shadow-md
           overflow-y-auto
           z-40
           -translate-x-full
           md:translate-x-0
           transition-transform duration-300">

    <div class="flex flex-col h-full">

        {{-- Header Sidebar --}}
        <div class="px-6 py-5 border-b border-gray-200 flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo DLH Jayapura" class="w-10 h-10 object-contain drop-shadow-sm">
            <div>
                <h2 class="text-base font-bold text-gray-800 leading-tight">
                    SIMPAS DLH
                </h2>
                <p class="text-xs text-gray-500 font-medium">
                    Kab. Jayapura
                </p>
            </div>
        </div>

        {{-- Menu --}}
        <nav class="flex-1 px-4 py-4">

            @if(auth()->user()->hasRole('admin'))
                @include('menus.admin')

            @elseif(auth()->user()->hasRole('driver'))
                @include('menus.driver')

            @elseif(auth()->user()->hasRole('kepala'))
                @include('menus.kepala')
            @endif

        </nav>

    </div>

</aside>