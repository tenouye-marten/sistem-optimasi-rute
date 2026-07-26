<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMPAS DLH</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#247838] md:bg-transparent font-sans text-gray-800 antialiased selection:bg-emerald-500 selection:text-white">

    <div class="min-h-screen grid grid-cols-1 md:grid-cols-2">
        
        {{-- Sisi Kiri (Hijau Tua) --}}
        <div class="bg-[#247838] text-white flex flex-col justify-between items-center p-8 md:p-12 relative min-h-[420px] md:min-h-screen">
            <div></div> {{-- Top Spacer --}}

            {{-- Branding Content --}}
            <div class="flex flex-col items-center text-center my-auto py-8">
                {{-- Logo Container Circle --}}
                <div class="bg-[#38944d] p-4 rounded-full shadow-inner w-24 h-24 md:w-28 md:h-28 flex items-center justify-center mb-6 border border-white/20">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo DLH Jayapura" class="max-w-full max-h-full object-contain filter drop-shadow">
                </div>

                {{-- Application Title --}}
                <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-white mb-1">
                    Sistem Optimasi Rute
                </h1>
                <p class="text-emerald-100 text-sm md:text-base font-normal mb-4">
                    Pengangkutan Sampah
                </p>

                {{-- Divider Line --}}
                <div class="w-16 h-0.5 bg-emerald-300/40 rounded-full my-3"></div>

                {{-- Department / Organization --}}
                <p class="text-emerald-100 text-xs md:text-sm mt-1">
                    Dinas Lingkungan Hidup
                </p>
                <p class="text-white font-bold text-sm md:text-base mt-0.5">
                    Kabupaten Jayapura
                </p>
            </div>

            {{-- Footer Copyright --}}
            <div class="w-full text-center md:text-left text-[11px] text-emerald-200/70 pt-4">
                &copy; 2026 DLH Kabupaten Jayapura
            </div>
        </div>

        {{-- Sisi Kanan (Hijau Mint Muda) --}}
        <div class="bg-[#b6f2ca] flex flex-col justify-center items-center p-6 md:p-12 min-h-screen">
            <div class="max-w-md w-full px-2 sm:px-6">
                
                {{-- Title & Subtitle --}}
                <div class="mb-8 text-left">
                    <h2 class="text-2xl md:text-3xl font-bold text-[#1b552b] mb-1 tracking-tight">
                        Login
                    </h2>
                    <p class="text-xs md:text-sm text-emerald-900/70">
                        Silakan masuk menggunakan email dan password Anda
                    </p>
                </div>

                {{-- Form Login --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    @if ($errors->any())
                        <div class="p-3.5 rounded-xl bg-red-100/80 border border-red-200 text-red-800 text-xs leading-relaxed">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label class="block text-xs font-semibold text-emerald-950 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full bg-white border border-emerald-400/50 focus:border-emerald-700 rounded-lg px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-600/20 transition shadow-sm"
                            placeholder="Email Anda">
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-semibold text-emerald-950">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[11px] text-emerald-800/80 hover:text-emerald-950 hover:underline">
                                    Lupa password?
                                </a>
                            @endif
                        </div>
                        <input type="password" name="password" required
                            class="w-full bg-white border border-emerald-400/50 focus:border-emerald-700 rounded-lg px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-600/20 transition shadow-sm"
                            placeholder="••••••••">
                    </div>

                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center gap-2 cursor-pointer text-emerald-900/80 select-none">
                            <input type="checkbox" name="remember" class="rounded text-emerald-700 focus:ring-emerald-600 border-emerald-400/70 bg-white/60">
                            <span>Ingat saya</span>
                        </label>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full bg-[#247838] hover:bg-[#1c612c] text-white font-semibold py-3 rounded-lg shadow hover:shadow-md transition duration-200 text-sm tracking-wide">
                            Masuk
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>

</body>
</html>