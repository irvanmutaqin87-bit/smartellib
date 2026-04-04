<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>Register SmartTellLib</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="min-h-screen bg-gray-50 py-8">

<form method="POST" action="{{ route('register.process') }}">
@csrf

<!-- ================= CARD UTAMA ================= -->
<div class="w-[1200px] min-h-[90vh] bg-white rounded-3xl shadow-2xl p-8 flex relative overflow-visible mx-auto">

    @if (session('success'))
        <div class="absolute top-6 left-1/2 -translate-x-1/2 z-50">
            <div class="backdrop-blur-xl bg-emerald-400/20 border border-emerald-300/40 
                        text-emerald-900 px-6 py-3 rounded-xl shadow-xl 
                        text-sm font-medium animate-fade-in">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="absolute top-6 left-1/2 -translate-x-1/2 z-50">
            <div class="backdrop-blur-xl bg-red-400/20 border border-red-300/40 
                        text-red-900 px-6 py-3 rounded-xl shadow-xl 
                        text-sm font-medium animate-fade-in">
                Silakan periksa kembali data yang diisi.
            </div>
        </div>
    @endif

    <div class="absolute top-10 right-64 z-10 reveal reveal-scale delay-400">
        <img src="/img/logo.png" class="w-56">
    </div>

    <!-- ================= KIRI : FORM REGISTER ================= -->
    <div class="w-[460px] bg-white rounded-2xl p-8 shadow-lg h-auto flex flex-col reveal reveal-up delay-100">

        <h1 class="text-2xl font-bold text-black mb-1 text-center">
            Daftar
        </h1>

        <p class="text-gray-500 mb-10 text-sm text-center max-w-xs mx-auto leading-normal">
            Buat akun untuk mengakses dan meminjam
            buku digital di SMARTELLIB.
        </p>

        <!-- Nama Lengkap -->
        <input 
            id="nama"
            type="text" 
            name="nama"
            value="{{ old('nama') }}"
            placeholder="Nama Lengkap"
            class="w-full mb-3 px-4 py-2.5 rounded-xl text-sm
            bg-gradient-to-br from-cyan-100/60 to-white/40
            border border-white/50
            backdrop-blur-md
            shadow-sm
            focus:ring-2 focus:ring-cyan-400/60
            focus:border-cyan-400
            hover:shadow-md
            outline-none transition-all duration-300
            @error('nama') border-red-400 ring-2 ring-red-300 @enderror">

            @error('nama')
            <p class="text-xs text-red-500 mb-2 ml-1 error-message"
            data-error-for="nama">
                {{ $message }}
            </p>
            @enderror


        <!-- EMAIL -->
        <input 
            id="email"
            type="email"    
            name="email"
            value="{{ old('email') }}"
            placeholder="Email"
            class="w-full mb-3 px-4 py-2.5 rounded-xl text-sm
            bg-gradient-to-br from-cyan-100/60 to-white/40
            border border-white/50
            backdrop-blur-md
            shadow-sm
            focus:ring-2 focus:ring-cyan-400/60
            focus:border-cyan-400
            hover:shadow-md
            outline-none transition-all duration-300
            @error('email') border-red-400 ring-2 ring-red-300 @enderror">

            @error('email')
            <p class="text-xs text-red-500 mb-2 ml-1 error-message"
            data-error-for="email">
                {{ $message }}
            </p>
            @enderror

        <!-- NOMOR HP -->
        <input 
            id="no_hp"
            type="text" 
            name="no_hp"
            value="{{ old('no_hp') }}"
            placeholder="Nomor HP"
            class="w-full mb-3 px-4 py-2.5 rounded-xl text-sm
            bg-gradient-to-br from-cyan-100/60 to-white/40
            border border-white/50
            backdrop-blur-md
            shadow-sm
            focus:ring-2 focus:ring-cyan-400/60
            focus:border-cyan-400
            hover:shadow-md
            outline-none transition-all duration-300
            @error('no_hp') border-red-400 ring-2 ring-red-300 @enderror">

            @error('no_hp')
            <p class="text-xs text-red-500 mb-2 ml-1 error-message"
            data-error-for="no_hp">
                {{ $message }}
            </p>
            @enderror

        <!-- ALAMAT -->
        <textarea 
            id="alamat"
            name="alamat"
            rows="3"
            placeholder="Alamat"
            class="w-full mb-3 px-4 py-2.5 rounded-xl text-sm resize-none
            bg-gradient-to-br from-cyan-100/60 to-white/40
            border border-white/50
            backdrop-blur-md
            shadow-sm
            focus:ring-2 focus:ring-cyan-400/60
            focus:border-cyan-400
            hover:shadow-md
            outline-none transition-all duration-300
            @error('alamat') border-red-400 ring-2 ring-red-300 @enderror">{{ old('alamat') }}</textarea>

            @error('alamat')
            <p class="text-xs text-red-500 mb-2 ml-1 error-message"
            data-error-for="alamat">
                {{ $message }}
            </p>
            @enderror


        <!-- PASSWORD -->
        <div class="relative mb-3">
            <input type="password"
                name="password"
                id="password"
                placeholder="Kata Sandi"
                class="w-full px-4 py-2.5 rounded-xl text-sm
                bg-gradient-to-br from-cyan-100/60 to-white/40
                border border-white/50
                backdrop-blur-md
                shadow-sm
                focus:ring-2 focus:ring-cyan-400/60
                focus:border-cyan-400
                hover:shadow-md
                outline-none transition-all duration-300
                @error('password') border-red-400 ring-2 ring-red-300 @enderror">

            <span id="togglePassword"
                class="absolute right-4 top-3 text-slate-500 cursor-pointer select-none hover:text-cyan-600 transition">
                <!-- SVG tetap -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12
                    18 19.5 12 19.5 2.25 12 2.25 12z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 15.75A3.75 3.75 0 1 0 12 8.25
                    a3.75 3.75 0 0 0 0 7.5z" />
                </svg>
            </span>
        </div>

        @error('password')
        <p class="text-xs text-red-500 mb-2 ml-1 error-message"
        data-error-for="password">
            {{ $message }}
        </p>
        @enderror

        <!-- KONFIRMASI PASSWORD -->
        <div class="relative mb-3">
            <input type="password" 
                name="password_confirmation"
                id="password_confirmation"
                placeholder="Konfirmasi Kata Sandi"
                class="w-full px-4 py-2.5 rounded-xl text-sm
                bg-gradient-to-br from-cyan-100/60 to-white/40
                border border-white/50
                backdrop-blur-md
                shadow-sm
                focus:ring-2 focus:ring-cyan-400/60
                focus:border-cyan-400
                hover:shadow-md
                outline-none transition-all duration-300
                @error('password_confirmation') border-red-400 ring-2 ring-red-300 @enderror">

            <span id="togglePasswordConfirm"
                class="absolute right-4 top-3 text-slate-500 cursor-pointer select-none hover:text-cyan-600 transition">
                <!-- SVG tetap -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12
                    18 19.5 12 19.5 2.25 12 2.25 12z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 15.75A3.75 3.75 0 1 0 12 8.25
                    a3.75 3.75 0 0 0 0 7.5z" />
                </svg>
            </span>
        </div>

        <p class="text-xs text-gray-400 mb-6 ml-2">
            Password minimal 8 karakter, wajib huruf besar, huruf kecil, dan angka.
        </p>

        @error('password_confirmation')
        <p class="text-xs text-red-500 mb-2 ml-1 error-message"
        data-error-for="password_confirmation">
            {{ $message }}
        </p>
        @enderror

        <!-- BUTTON DAFTAR -->
        <button 
            id="registerButton"
            type="submit"
            class="w-full py-2.5 rounded-xl text-white font-semibold
            bg-gradient-to-r from-cyan-400 via-sky-500 to-sky-400
            shadow-md shadow-cyan-200/40
            hover:from-cyan-500 hover:via-sky-600 hover:to-sky-500
            hover:shadow-lg hover:shadow-cyan-300/50
            active:opacity-90
            transition-all duration-300
            flex items-center justify-center gap-2">
            <span id="registerText">Daftar</span>

            <svg id="registerSpinner"
                class="hidden w-4 h-4 animate-spin"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25"
                    cx="12" cy="12" r="10"
                    stroke="currentColor"
                    stroke-width="4"></circle>
                <path class="opacity-75"
                    fill="currentColor"
                    d="M4 12a8 8 0 018-8v8z"></path>
            </svg>
        </button>

        <p class="text-center text-gray-500 mt-2 text-sm">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-right text-cyan-600 text-sm mb-4 hover:underline cursor-pointer transition">
                Masuk
            </a>
        </p>

    </div>

    <!-- ================= KANAN : ILUSTRASI ================= -->
    <div class="flex-1 flex items-center justify-center mt-24 reveal reveal-up delay-300">
        <div class="rounded-xl p-6">
            <img src="/img/Sign up.gif" class="w-[400px] max-w-full">
        </div>
    </div>

</div>

</form>

</body>
</html>