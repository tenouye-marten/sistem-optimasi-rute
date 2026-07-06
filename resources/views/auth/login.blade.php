<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - DLH Kab. Jayapura</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Tailwind / Vite Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-50">

    <div class="flex min-h-screen w-full">
        
        <!-- Panel Kiri: Branding (Standard Solid Green) -->
        <div class="hidden lg:flex lg:w-1/2 bg-green-700 flex-col items-center justify-center p-12 text-white">
            
            <!-- Logo Sederhana -->
            <div class="bg-green-600 p-4 rounded-full mb-6">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold text-center mb-2">
                Sistem Optimasi Rute
            </h1>
            <h2 class="text-xl text-green-200 font-medium text-center mb-8">
                Pengangkutan Sampah
            </h2>
            
            <div class="w-16 h-1 bg-green-500 rounded mb-8"></div>
            
            <p class="text-center text-green-50 text-lg">
                Dinas Lingkungan Hidup <br>
                <span class="font-semibold">Kabupaten Jayapura</span>
            </p>

            <div class="absolute bottom-6 text-sm text-green-300">
                &copy; {{ date('Y') }} DLH Kabupaten Jayapura
            </div>
        </div>

        <!-- Panel Kanan: Area Form Login -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 bg-gray-50">
            
            <!-- Kotak Form Standard -->
            <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-sm border border-gray-200">
                
                <div class="mb-8 text-center lg:text-left">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Login</h3>
                    <p class="text-sm text-gray-600">Silakan masuk menggunakan email dan password Anda.</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-4 rounded-md">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Input Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                            class="block w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 sm:text-sm">
                        @error('email')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Password -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-green-600 hover:text-green-700">
                                    Lupa password?
                                </a>
                            @endif
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password" 
                            class="block w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 sm:text-sm">
                        @error('password')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center mt-4">
                        <input id="remember_me" type="checkbox" name="remember" 
                            class="h-4 w-4 border-gray-300 rounded text-green-600 focus:ring-green-600">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Tombol Login -->
                    <div class="pt-2">
                        <button type="submit" 
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600">
                            Masuk
                        </button>
                    </div>
                </form>

                <!-- Identitas Mobile (Muncul di layar kecil saja) -->
                <div class="lg:hidden mt-8 pt-6 border-t border-gray-200 text-center">
                    <p class="text-xs text-gray-500">
                        Sistem Optimasi Rute Pengangkutan Sampah <br>
                        <span class="font-semibold text-green-700">DLH Kab. Jayapura</span>
                    </p>
                </div>

            </div>
        </div>
    </div>

</body>
</html>