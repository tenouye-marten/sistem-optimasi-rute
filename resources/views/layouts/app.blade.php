<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', config('app.name'))</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @stack('styles')
</head>

<body class="bg-gray-100">

    {{-- Navbar --}}
    @include('components.navbar')

    <div class="flex pt-16">

        {{-- Sidebar --}}
        @include('components.sidebar')

        {{-- Content --}}
        <main class="flex-1 md:ml-64 min-h-[calc(100vh-4rem)] flex flex-col">

            <div class="flex-1 p-6">

                @yield('content')

            </div>

            {{-- Footer --}}
            @include('components.footer')

        </main>

    </div>

    @stack('scripts')

</body>

</html>