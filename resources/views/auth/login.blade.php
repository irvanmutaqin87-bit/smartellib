<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>Login SMARTELLIB</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-50 py-8">

<form method="POST" action="{{ route('login.process') }}">
@csrf

<!-- ================= CARD UTAMA ================= -->
<div class="w-[1200px] min-h-[90vh] bg-white rounded-3xl shadow-2xl p-8 flex relative overflow-visible">

    <!-- TOAST SUCCESS -->
    @if(session('success'))
        <div class="absolute top-6 left-1/2 -translate-x-1/2 z-50">
            <div class="backdrop-blur-xl bg-emerald-400/20 border border-emerald-300/40 
                        text-emerald-900 px-6 py-3 rounded-xl shadow-xl 
                        text-sm font-medium animate-fade-in">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- TOAST ERROR (DINAMIS DARI CONTROLLER) -->
    @if(session('error'))
        <div class="absolute top-6 left-1/2 -translate-x-1/2 z-50">
            <div class="backdrop-blur-xl bg-red-400/20 border border-red-300/40 
                        text-red-900 px-6 py-3 rounded-xl shadow-xl 
                        text-sm font-medium animate-fade-in">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- LOGO -->
    <div class="absolute top-10 right-64 z-10 reveal reveal-scale delay-400">
        <img src="{{ asset('/img/logo.png') }}" class="w-56">
    </div>

    <!-- ================= KIRI : FORM LOGIN ================= -->
    <div class="w-[460px] bg-white rounded-2xl p-8 shadow-lg h-full flex flex-col justify-center reveal reveal-up delay-100">

        <h1 class="text-2xl font-bold text-black mb-1 text-center">
            Masuk ke Akun Anda
        </h1>

        <p class="text-gray-500 mb-12 text-sm text-center max-w-xs mx-auto leading-normal">
            Akses layanan perpustakaan digital SMARTELLIB dengan akun Anda.
        </p>

        <!-- EMAIL -->
        <input 
            id="email"
            type="email" 
            name="email"
            value="{{ old('email') }}"
            placeholder="Email"
            class="w-full mb-4 px-4 py-3 rounded-xl text-sm
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

        <!-- PASSWORD -->
        <div class="relative mb-4">
            <input type="password"
                name="password"
                id="password"
                placeholder="Kata Sandi"
                class="w-full px-4 py-3 rounded-xl text-sm
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
                class="absolute right-4 top-3 text-slate-500 cursor-pointer hover:text-cyan-600 transition">
            </span>
        </div>

        @error('password')
        <p class="text-xs text-red-500 mb-2 ml-1 error-message"
        data-error-for="password">
            {{ $message }}
        </p>
        @enderror

        <div class="flex justify-between items-center mb-6">
            <!-- Ingat Saya -->
            <label class="inline-flex items-center text-sm text-cyan-600">
                <input type="checkbox" name="remember" class="form-checkbox mr-2 accent-cyan-600">
                Ingat Saya
            </label>

            <!-- Lupa Kata Sandi -->
            <a href="{{ route('password.request') }}"
            class="text-sm text-cyan-600 hover:text-cyan-700 hover:underline transition">
                Lupa Kata Sandi?
            </a>
        </div>

        <!-- BUTTON LOGIN -->
        <button 
            id="loginButton"
            type="submit"
            class="w-full py-2.5 rounded-xl text-white font-semibold
            bg-gradient-to-r from-cyan-400 via-sky-500 to-sky-400
            shadow-md shadow-cyan-200/40
            hover:from-cyan-500 hover:via-sky-600 hover:to-sky-500
            hover:shadow-lg hover:shadow-cyan-300/50
            active:opacity-90
            transition-all duration-300
            flex items-center justify-center gap-2">
            <span  id="loginText">Masuk</span>

            <svg id="loginSpinner"
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

        <!-- DIVIDER -->
        <div class="flex items-center gap-4 my-4 text-gray-400 text-sm">
            <hr class="flex-1 border-gray-200">
            Atau
            <hr class="flex-1 border-gray-200">
        </div>

        <!-- LOGIN GOOGLE -->
        <button type="button"
            class="w-full border border-gray-300 rounded-lg py-2.5 flex
            items-center justify-center gap-3 hover:bg-gray-50 transition">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5">
            <a href="{{ route('google.login') }}" class="font-medium text-gray-600">Google</a>
        </button>

        <!-- LINK REGISTER -->
        <p class="text-center text-gray-500 mt-4 text-sm">
            Belum punya akun?
            <a href="{{ route('register') }}"
                class="text-cyan-600 hover:underline transition">
                Daftar Sekarang
            </a>
        </p>

    </div>

    <!-- ================= KANAN : ILUSTRASI ================= -->
    <div class="flex-1 flex items-center justify-center mt-24 reveal reveal-up delay-300">
        <div class="rounded-xl p-6">
            <img src="/img/Tablet_login.gif" class="w-[400px] max-w-full">
        </div>
    </div>

</div>
</form>

</body>
</html>