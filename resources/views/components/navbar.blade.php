<nav class="fixed top-0 left-0 right-0 z-50 h-16 bg-green-700 shadow-lg">

    <div class="h-full flex items-center justify-between px-6">

        {{-- Logo & Menu --}}
        <div class="flex items-center gap-4">

            {{-- Tombol Sidebar (Mobile) --}}
            <button
                id="menuButton"
                class="md:hidden text-2xl font-bold text-white focus:outline-none">

                ☰

            </button>

            {{-- Logo --}}
            <div>

                <h1 class="text-xl font-bold text-white">
                    SIMPAS DLH
                </h1>

                <p class="text-xs text-green-100">
                    Sistem Optimasi Rute Pengangkutan Sampah
                </p>

            </div>

        </div>

        {{-- User --}}
        <div class="flex items-center gap-5">

            <div class="hidden md:block text-right">

                <p class="font-semibold text-white">
                    {{ auth()->user()->name }}
                </p>

                <p class="text-xs text-green-100 capitalize">
                    {{ auth()->user()->getRoleNames()->first() }}
                </p>

            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-700">

                    Logout

                </button>

            </form>

        </div>

    </div>

</nav>