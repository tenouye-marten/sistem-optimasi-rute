<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', config('app.name', 'SIMPAS DLH'))</title>

    <!-- Favicon / Logo Icon PNG -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- FontAwesome 6 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

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