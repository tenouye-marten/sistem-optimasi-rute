<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMPAS DLH</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        
        {{-- Header Green Banner --}}
        <div class="bg-emerald-700 p-8 text-center text-white flex flex-col items-center">
            {{-- Badge Putih untuk Logo agar warna tidak bertabrakan dengan background hijau --}}
            <div class="bg-white p-2.5 rounded-full shadow-md w-24 h-24 flex items-center justify-center mb-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo DLH Jayapura" class="max-w-full max-h-full object-contain">
            </div>
            <h1 class="text-2xl font-bold tracking-tight">SIMPAS DLH</h1>
            <p class="text-xs text-emerald-100 mt-1">Sistem Optimasi Rute Pengangkutan Sampah<br>Dinas Lingkungan Hidup Kab. Jayapura</p>
        </div>

        {{-- Form Login --}}
        <form method="POST" action="{{ route('login') }}" class="p-8 space-y-5">
            @csrf

            @if ($errors->any())
                <div class="p-3.5 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm text-gray-800 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 shadow-sm"
                    placeholder="admin@dlh.com">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm text-gray-800 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 shadow-sm"
                    placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2 cursor-pointer text-gray-600">
                    <input type="checkbox" name="remember" class="rounded text-emerald-600 focus:ring-emerald-500">
                    <span>Ingat Saya</span>
                </label>
            </div>

            <button type="submit"
                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 rounded-lg shadow-sm transition">
                Masuk Ke Sistem
            </button>
        </form>
    </div>
</body>
</html>