<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <title>SmartTellib - Perpustakaan Digital</title>

    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class=" min-h-screen overflow-x-hidden">

        {{-- Redirect otomatis jika sudah login --}}
    @if(Auth::check())
        <script>
            window.location.href = "{{ route('anggota.beranda') }}";
        </script>
    @endif
    
<div class="h-full flex flex-col">
    <nav class="w-full px-20 py-8 flex items-center justify-between relative  reveal reveal-scale delay-500 ">
        <div>
            <img src="{{ asset('/img/logo.png') }}" class="w-52">
        </div>

        <ul class="absolute left-1/2 -translate-x-1/2 
                    flex items-center gap-12 
                    text-gray-700 font-semibold text-[16px]
                    [text-shadow:0_2px_6px_rgba(0,0,0,0.15)]
                    ">

            <li>
                <a href="#beranda" class="text-slate-600 hover:text-cyan-500/90 transition-colors">
                    Beranda
                </a>
            </li>
            <li>
                <a href="#fitur" class="text-slate-600 hover:text-cyan-500/90 transition-colors">
                    Fitur
                </a>
            </li>
            <li>
                <a href="#kategori" class="text-slate-600 hover:text-cyan-500/90 transition-colors">
                    Kategori Buku
                </a>
            </li>
            <li>
                <a href="#tentang" class="text-slate-600 hover:text-cyan-500/90 transition-colors">
                    Tentang Kami
                </a>
            </li>
        </ul>

            <div class="flex items-center gap-4">

                <a href="{{ route('register') }}"
                class="px-6 py-2 rounded-xl 
                        bg-white text-gray-700 font-medium
                        shadow-lg
                        transition-all duration-300 ease-out
                        hover:bg-cyan-50 hover:text-cyan-700
                        hover:shadow-xl hover:scale-105
                        active:scale-95">
                    Daftar
                </a>


                <a href="{{ route('login') }}"
                class="px-6 py-2 rounded-xl 
                        bg-gradient-to-r from-blue-500 via-cyan-400 to-indigo-500
                        text-white font-medium
                        shadow-lg
                        transition-all duration-300 ease-out
                        hover:from-blue-600 hover:via-cyan-500 hover:to-indigo-600
                        hover:shadow-2xl hover:scale-105
                        active:scale-95">
                    Login
                </a>

            </div>
    </nav>

    <!-- NAVBAR SCROLL -->
    <nav id="navbarScroll"
        class="fixed top-0 left-0 w-full px-20 py-5 
                bg-white/70 backdrop-blur-xl shadow-md
                flex items-center justify-between
                transform -translate-y-full
                transition-all duration-500 z-50">

        <!-- Logo -->
        <div>
            <img src="{{ asset('/img/logo.png') }}" class="w-40">
        </div>

        <!-- Menu -->
        <ul class="flex items-center gap-10 
                text-gray-700 font-semibold text-[15px]">

            <li><a href="#beranda" class="hover:text-cyan-600 transition">Beranda</a></li>
            <li><a href="#fitur" class="hover:text-cyan-600 transition">Fitur</a></li>
            <li><a href="#kategori" class="hover:text-cyan-600 transition">Kategori</a></li>
            <li><a href="#tentang" class="hover:text-cyan-600 transition">Tentang Kami</a></li>
        </ul>

            <div class="flex items-center gap-4">

                <a href="{{ route('register') }}"
                class="px-6 py-2 rounded-xl 
                        bg-white text-gray-700 font-medium
                        shadow-lg
                        transition-all duration-300 ease-out
                        hover:bg-cyan-50 hover:text-cyan-700
                        hover:shadow-xl hover:scale-105
                        active:scale-95">
                    Daftar
                </a>


                <a href="{{ route('login') }}"
                class="px-6 py-2 rounded-xl 
                        bg-gradient-to-r from-blue-500 via-cyan-400 to-indigo-500
                        text-white font-medium
                        shadow-lg
                        transition-all duration-300 ease-out
                        hover:from-blue-600 hover:via-cyan-500 hover:to-indigo-600
                        hover:shadow-2xl hover:scale-105
                        active:scale-95">
                    Login
                </a>

            </div>
    </nav>

        <section id="beranda" class="min-h-[calc(100vh-80px)] px-20 grid grid-cols-2 items-center relative">
            <div class="relative w-full flex flex-col items-center text-center mt-2 reveal reveal-left delay-100">

            <div class="px-4 py-2 rounded-full
                        bg-gradient-to-r from-cyan-400 via-sky-500 to-cyan-400
                        text-white text-sm font-medium mb-4 shadow-md">
                Smart Digital Library Solution
            </div>

            <h1 class="text-3xl font-extrabold leading-[1.2] 
                        text-[#2F5D5B] mb-3 max-w-4xl drop-shadow-xl">
                Kelola Perpustakaan Lebih Cerdas,
                Cepat, dan Terintegrasi dalam
                Satu Platform Digital
            </h1>
            <p class="text-gray-500 text-sm leading-relaxed 
                            max-w-sm mb-3 drop-shadow-xl">
                SMARTELLIB membantu perpustakaan mengelola koleksi buku,
                peminjaman, dan laporan secara efisien,
                aman, dan terpusat.
            </p>
            <a href="{{ route('register') }}"
            class="inline-flex items-center gap-4 px-6 py-3 rounded-2xl
                    bg-gradient-to-r from-cyan-400 via-sky-500 to-cyan-400
                    text-white font-semibold text-md
                    shadow-lg drop-shadow-md

                    transition-all duration-300 ease-out
                    hover:from-cyan-500 hover:via-sky-600 hover:to-cyan-500
                    hover:shadow-sm hover:scale-[1.03]
                    active:scale-95">

                Mulai Gunakan SMARTELLIB

                <svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    class="w-6 h-6 transition-transform duration-300 group-hover:translate-x-1">
                    <path fill-rule="evenodd"
                        d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z"
                        clip-rule="evenodd" />
                </svg>
            </a>

            <p class="text-sm text-gray-600 mt-2">
                Gratis, berbasis web, dan mudah digunakan.
            </p>
        </div>


        <!-- RIGHT (LOTTIE) -->
        <div class="flex justify-end items-center reveal reveal-right delay-300">
            <div class="w-[500px]">
                <lottie-player
                    src="{{ asset('/img/beranda.json') }}"
                    background="transparent"
                    speed="1"
                    loop
                    autoplay>
                </lottie-player>
            </div>
        </div>
    </div>
    </section>

    <section id="fitur" class=" py-20 px-36 min-h-screen">

    <!-- Header -->
    <div class="text-center mb-16 reveal reveal-up delay-100">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">
            Fitur Utama SMARTELLIB
        </h2>
        <p class="text-gray-600 mx-auto">
            Berbagai fitur yang mendukung layanan perpustakaan digital berbasis web 
            secara efektif dan terintegrasi.
        </p>
    </div>


    <!-- GRID FITUR -->
    <div class="max-w-6xl mx-auto grid grid-cols-3 gap-10">
        <div class="
            bg-gradient-to-br from-cyan-200/80 via-cyan-100/60 to-white/70
            rounded-3xl
            p-10
            text-center
            shadow-lg
            border border-white/40
            backdrop-blur-md
            transition-all duration-300
            hover:scale-[1.02]
            hover:-translate-y-0.5
            hover:shadow-xl
            hover:ring-2 hover:ring-cyan-300/30
            reveal reveal-up delay-100
            ">


            <div class="flex justify-center mb-6 text-cyan-500 drop-shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-20">
                <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                </svg>
            </div>
            <h3 class="font-semibold mb-3">
                Koleksi & Pencarian Buku
            </h3>

            <p class="text-sm leading-relaxed">
                Cari dan jelajahi koleksi buku digital dengan 
                cepat dan mudah.
            </p>
        </div>

        <div class="
            bg-gradient-to-br from-cyan-200/80 via-cyan-100/60 to-white/70
            rounded-3xl
            p-10
            text-center
            shadow-lg
            border border-white/40
            backdrop-blur-md
            transition-all duration-300
            hover:scale-[1.02]
            hover:-translate-y-0.5
            hover:shadow-xl
            hover:ring-2 hover:ring-cyan-300/30
            reveal reveal-up delay-200
            ">


            <div class="flex justify-center mb-6 text-cyan-500 drop-shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-20">
                    <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                    <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 18a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V18Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                </svg>
            </div>
            <h3 class="font-semibold mb-3">
                Peminjaman Buku Digital
            </h3>

            <p class="text-sm leading-relaxed">
                Ajukan peminjaman buku digital 
                secara online tanpa harus 
                datang ke perpustakaan.
            </p>
        </div>

        <div class="
            bg-gradient-to-br from-cyan-200/80 via-cyan-100/60 to-white/70
            rounded-3xl
            p-10
            text-center
            shadow-lg
            border border-white/40
            backdrop-blur-md
            transition-all duration-300
            hover:scale-[1.02]
            hover:-translate-y-0.5
            hover:shadow-xl
            hover:ring-2 hover:ring-cyan-300/30
            reveal reveal-up delay-300
            ">


            <div class="flex justify-center mb-6 text-cyan-500 drop-shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-20">
                    <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                    <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clip-rule="evenodd" />
                </svg>

            </div>
            <h3 class="font-semibold mb-3">
                Verifikasi Peminjaman
            </h3>

            <p class="text-sm leading-relaxed">
                Petugas memverifikasi peminjaman
                untuk memastikan proses
                berjalan dengan tertib.
            </p>
        </div>


        <div class="
            bg-gradient-to-br from-cyan-200/80 via-cyan-100/60 to-white/70
            rounded-3xl
            p-10
            text-center
            shadow-lg
            border border-white/40
            backdrop-blur-md
            transition-all duration-300
            hover:scale-[1.02]
            hover:-translate-y-0.5
            hover:shadow-xl
            hover:ring-2 hover:ring-cyan-300/30
            reveal reveal-up delay-400
            ">


            <div class="flex justify-center mb-6 text-cyan-500 drop-shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-20">
                    <path fill-rule="evenodd" d="M3.75 3.375c0-1.036.84-1.875 1.875-1.875H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375Zm10.5 1.875a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25ZM12 10.5a.75.75 0 0 1 .75.75v.028a9.727 9.727 0 0 1 1.687.28.75.75 0 1 1-.374 1.452 8.207 8.207 0 0 0-1.313-.226v1.68l.969.332c.67.23 1.281.85 1.281 1.704 0 .158-.007.314-.02.468-.083.931-.83 1.582-1.669 1.695a9.776 9.776 0 0 1-.561.059v.028a.75.75 0 0 1-1.5 0v-.029a9.724 9.724 0 0 1-1.687-.278.75.75 0 0 1 .374-1.453c.425.11.864.186 1.313.226v-1.68l-.968-.332C9.612 14.974 9 14.354 9 13.5c0-.158.007-.314.02-.468.083-.931.831-1.582 1.67-1.694.185-.025.372-.045.56-.06v-.028a.75.75 0 0 1 .75-.75Zm-1.11 2.324c.119-.016.239-.03.36-.04v1.166l-.482-.165c-.208-.072-.268-.211-.268-.285 0-.113.005-.225.015-.336.013-.146.14-.309.374-.34Zm1.86 4.392V16.05l.482.165c.208.072.268.211.268.285 0 .113-.005.225-.015.336-.012.146-.14.309-.374.34-.12.016-.24.03-.361.04Z" clip-rule="evenodd" />
                </svg>
            </div>
            <h3 class="font-semibold mb-3">
                Pengembalian & Denda Otomatis
            </h3>

            <p class="text-sm leading-relaxed">
                Pengembalian buku tercatat 
                otomatis beserta perhitungan
                denda keterlambatan.
            </p>
        </div>


        <div class="
            bg-gradient-to-br from-cyan-200/80 via-cyan-100/60 to-white/70
            rounded-3xl
            p-10
            text-center
            shadow-lg
            border border-white/40
            backdrop-blur-md
            transition-all duration-300
            hover:scale-[1.02]
            hover:-translate-y-0.5
            hover:shadow-xl
            hover:ring-2 hover:ring-cyan-300/30
            reveal reveal-up delay-500
            ">


            <div class="flex justify-center mb-6 text-cyan-500 drop-shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-20">
                    <path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875ZM9.75 17.25a.75.75 0 0 0-1.5 0V18a.75.75 0 0 0 1.5 0v-.75Zm2.25-3a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3a.75.75 0 0 1 .75-.75Zm3.75-1.5a.75.75 0 0 0-1.5 0V18a.75.75 0 0 0 1.5 0v-5.25Z" clip-rule="evenodd" />
                    <path d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Z" />
                </svg>
            </div>
            <h3 class="font-semibold mb-3">
                Laporan Perpustakaan
            </h3>

            <p class="text-sm leading-relaxed">
                Lihat laporan peminjaman
                buku untuk monitoring 
                dan evaluasi layanan.
            </p>
        </div>


        <div class="
            bg-gradient-to-br from-cyan-200/80 via-cyan-100/60 to-white/70
            rounded-3xl
            p-10
            text-center
            shadow-lg
            border border-white/40
            backdrop-blur-md
            transition-all duration-300
            hover:scale-[1.02]
            hover:-translate-y-0.5
            hover:shadow-xl
            hover:ring-2 hover:ring-cyan-300/30
            reveal reveal-up delay-600
            ">


            <div class="flex justify-center mb-6 text-cyan-500 drop-shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-20">
                    <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
                </svg>

            </div>
            <h3 class="font-semibold mb-3">
                Manajemen Pengguna
            </h3>

            <p class="text-sm leading-relaxed">
                Kelola akun dan hak
                akses pengguna sesuai 
                peran dalam sistem.
            </p>
        </div>
    </div>
</section>

<section id="kategori" class="py-24 px-20">
    <div class="text-center mb-16 reveal reveal-up delay-100">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">
            Kategori Buku Digital
        </h2>
        <p class="text-gray-600 mx-auto">
            Jelajahi berbagai kategori buku digital yang tersedia untuk mendukung kebutuhan belajar, 
            pengetahuan, dan minat baca Anda.
        </p>
    </div>

    <div class="mx-auto grid grid-cols-3 gap-y-20 gap-x-16 text-center">
        <div>
            <div class="
                w-28 h-28 
                rounded-full 
                flex items-center justify-center 
                mx-auto mb-6
                bg-gradient-to-br 
                from-cyan-200/90 
                via-cyan-100/70 
                to-white/50
                border border-white/60
                backdrop-blur-md
                shadow-lg
                ring-2 ring-cyan-300/40
                text-cyan-500
                transition duration-300
                hover:scale-105
                reveal reveal-scale delay-100
            ">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-16">
                    <path fill-rule="evenodd" d="M2.25 5.25a3 3 0 0 1 3-3h13.5a3 3 0 0 1 3 3V15a3 3 0 0 1-3 3h-3v.257c0 .597.237 1.17.659 1.591l.621.622a.75.75 0 0 1-.53 1.28h-9a.75.75 0 0 1-.53-1.28l.621-.622a2.25 2.25 0 0 0 .659-1.59V18h-3a3 3 0 0 1-3-3V5.25Zm1.5 0v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5Z" clip-rule="evenodd" />
                </svg>
            </div>
            <h3 class="text-cyan-900 font-semibold text-xl mb-2 reveal reveal-scale delay-100">
                Teknologi Informasi
            </h3>
            <p class="text-slate-600 leading-normal max-w-lg mx-auto reveal reveal-scale delay-100">
                Koleksi buku yang membahas perkembangan teknologi, sistem informasi,
                pemrograman, dan penggunaan komputer dalam berbagai bidang.
            </p>
        </div>

        <div>
            <div class="
                w-28 h-28 
                rounded-full 
                flex items-center justify-center 
                mx-auto mb-6
                bg-gradient-to-br 
                from-cyan-200/90 
                via-cyan-100/70 
                to-white/50
                border border-white/60
                backdrop-blur-md
                shadow-lg
                ring-2 ring-cyan-300/40
                text-cyan-500
                transition duration-300
                hover:scale-105
                reveal reveal-scale delay-200
            ">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-16">
                    <path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                    <path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                    <path d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
                </svg>

            </div>
            <h3 class="text-cyan-900 font-semibold text-xl mb-2 reveal reveal-scale delay-200">
                Pendidikan
            </h3>
            <p class="text-slate-600 leading-normal max-w-lg mx-auto reveal reveal-scale delay-200">
                Berisi buku-buku referensi pembelajaran, materi akademik, serta panduan pendidikan yang mendukung proses belajar mengajar di berbagai jenjang pendidikan.
            </p>
        </div>

        <div>
            <div class="
                w-28 h-28 
                rounded-full 
                flex items-center justify-center 
                mx-auto mb-6
                bg-gradient-to-br 
                from-cyan-200/90 
                via-cyan-100/70 
                to-white/50
                border border-white/60
                backdrop-blur-md
                shadow-lg
                ring-2 ring-cyan-300/40
                text-cyan-500
                transition duration-300
                hover:scale-105
                reveal reveal-scale delay-300
            ">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-16">
                    <path fill-rule="evenodd" d="M10.5 3.798v5.02a3 3 0 0 1-.879 2.121l-2.377 2.377a9.845 9.845 0 0 1 5.091 1.013 8.315 8.315 0 0 0 5.713.636l.285-.071-3.954-3.955a3 3 0 0 1-.879-2.121v-5.02a23.614 23.614 0 0 0-3 0Zm4.5.138a.75.75 0 0 0 .093-1.495A24.837 24.837 0 0 0 12 2.25a25.048 25.048 0 0 0-3.093.191A.75.75 0 0 0 9 3.936v4.882a1.5 1.5 0 0 1-.44 1.06l-6.293 6.294c-1.62 1.621-.903 4.475 1.471 4.88 2.686.46 5.447.698 8.262.698 2.816 0 5.576-.239 8.262-.697 2.373-.406 3.092-3.26 1.47-4.881L15.44 9.879A1.5 1.5 0 0 1 15 8.818V3.936Z" clip-rule="evenodd" />
                </svg>
            </div>
            <h3 class="text-cyan-900 font-semibold text-xl mb-2 reveal reveal-scale delay-300">
                Sains
            </h3>
            <p class="text-slate-600 leading-normal max-w-lg mx-auto reveal reveal-scale delay-300">
                Menyediakan buku-buku ilmiah yang membahas sains alam, penelitian, serta pengetahuan umum untuk memperluas wawasan dan pemahaman terhadap fenomena alam dan teknologi.
            </p>
        </div>


        <div>
            <div class="
                w-28 h-28 
                rounded-full 
                flex items-center justify-center 
                mx-auto mb-6
                bg-gradient-to-br 
                from-cyan-200/90 
                via-cyan-100/70 
                to-white/50
                border border-white/60
                backdrop-blur-md
                shadow-lg
                ring-2 ring-cyan-300/40
                text-cyan-500
                transition duration-300
                hover:scale-105
                reveal reveal-scale delay-400
            ">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-16">
                    <path fill-rule="evenodd" d="M6.32 2.577a49.255 49.255 0 0 1 11.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 0 1-1.085.67L12 18.089l-7.165 3.583A.75.75 0 0 1 3.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93Z" clip-rule="evenodd" />
                </svg>
            </div>
            <h3 class="text-cyan-900 font-semibold text-xl mb-2 reveal reveal-scale delay-400">
                Sastra & Novel
            </h3>
            <p class="text-slate-600 leading-normal max-w-lg mx-auto reveal reveal-scale delay-400">
                Kumpulan karya sastra, novel, cerpen, dan bacaan fiksi yang bertujuan untuk menghibur sekaligus meningkatkan minat 
                dan budaya membaca.
            </p>
        </div>


        <div>
            <div class="
                w-28 h-28 
                rounded-full 
                flex items-center justify-center 
                mx-auto mb-6
                bg-gradient-to-br 
                from-cyan-200/90 
                via-cyan-100/70 
                to-white/50
                border border-white/60
                backdrop-blur-md
                shadow-lg
                ring-2 ring-cyan-300/40
                text-cyan-500
                transition duration-300
                hover:scale-105
                reveal reveal-scale delay-500
            ">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-16">
                    <path d="M11.584 2.376a.75.75 0 0 1 .832 0l9 6a.75.75 0 1 1-.832 1.248L12 3.901 3.416 9.624a.75.75 0 0 1-.832-1.248l9-6Z" />
                    <path fill-rule="evenodd" d="M20.25 10.332v9.918H21a.75.75 0 0 1 0 1.5H3a.75.75 0 0 1 0-1.5h.75v-9.918a.75.75 0 0 1 .634-.74A49.109 49.109 0 0 1 12 9c2.59 0 5.134.202 7.616.592a.75.75 0 0 1 .634.74Zm-7.5 2.418a.75.75 0 0 0-1.5 0v6.75a.75.75 0 0 0 1.5 0v-6.75Zm3-.75a.75.75 0 0 1 .75.75v6.75a.75.75 0 0 1-1.5 0v-6.75a.75.75 0 0 1 .75-.75ZM9 12.75a.75.75 0 0 0-1.5 0v6.75a.75.75 0 0 0 1.5 0v-6.75Z" clip-rule="evenodd" />
                    <path d="M12 7.875a1.125 1.125 0 1 0 0-2.25 1.125 1.125 0 0 0 0 2.25Z" />
                </svg>

            </div>
            <h3 class="text-cyan-900 font-semibold text-xl mb-2 reveal reveal-scale delay-500">
                Sejarah
            </h3>
            <p class="text-slate-600 leading-normal max-w-lg mx-auto reveal reveal-scale delay-500">
                Memuat buku-buku sejarah nasional maupun internasional yang membahas peristiwa penting, tokoh berpengaruh, dan perkembangan peradaban manusia.
            </p>
        </div>


        <div>
            <div class="
                w-28 h-28 
                rounded-full 
                flex items-center justify-center 
                mx-auto mb-6
                bg-gradient-to-br 
                from-cyan-200/90 
                via-cyan-100/70 
                to-white/50
                border border-white/60
                backdrop-blur-md
                shadow-lg
                ring-2 ring-cyan-300/40
                text-cyan-500
                transition duration-300
                hover:scale-105
                reveal reveal-scale delay-600
            ">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-16">
                    <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm4.5 7.5a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-1.5 0v-2.25a.75.75 0 0 1 .75-.75Zm3.75-1.5a.75.75 0 0 0-1.5 0v4.5a.75.75 0 0 0 1.5 0V12Zm2.25-3a.75.75 0 0 1 .75.75v6.75a.75.75 0 0 1-1.5 0V9.75A.75.75 0 0 1 13.5 9Zm3.75-1.5a.75.75 0 0 0-1.5 0v9a.75.75 0 0 0 1.5 0v-9Z" clip-rule="evenodd" />
                </svg>
            </div>
            <h3 class="text-cyan-900 font-semibold text-xl mb-2 reveal reveal-scale delay-600">
                Ekonomi & Bisnis
            </h3>
            <p class="text-slate-600 leading-normal max-w-lg mx-auto reveal reveal-scale delay-600">
                Koleksi buku yang membahas manajemen, ekonomi, kewirausahaan, dan dunia bisnis sebagai referensi dalam pengembangan pengetahuan dan keterampilan profesional.            </p>
        </div>
    </div>


    <!-- BUTTON -->
    <div class="flex justify-center mt-10 reveal reveal-scale delay-600">
        <a href="{{ route('register') }}"
            class="inline-flex items-center gap-4 px-6 py-3 rounded-2xl
                    bg-gradient-to-r from-cyan-400 via-sky-500 to-cyan-400
                    text-white font-semibold text-md
                    shadow-lg drop-shadow-md

                    transition-all duration-300 ease-out
                    hover:from-cyan-500 hover:via-sky-600 hover:to-cyan-500
                    hover:shadow-sm hover:scale-[1.03]
                    active:scale-95">
            Daftar Sekarang
        </a>
    </div>

</section>

<section id="tentang">

    <!-- HEADER ATAS -->
    <div class="relative 
        bg-gradient-to-br from-cyan-200/80 via-cyan-100/60 to-white/70
        px-20 pt-20 pb-40 
        overflow-hidden
        backdrop-blur-md
        border-b border-white/50
        reveal reveal-up delay-100
    ">
        <h1 class="text-4xl font-bold text-cyan-900 mb-4">
            SMARTELLIB Perpustakaan Digital Berbasis Web
        </h1>

        <p class="text-slate-600 max-w-2xl">
            Mengenal sistem perpustakaan digital yang mendukung akses pengetahuan
            secara cerdas dan modern
        </p>

        <!-- WAVE PUTIH -->
        <div class="absolute bottom-0 left-0 w-full leading-none">
            <svg viewBox="0 0 1440 320" class="w-full h-40" preserveAspectRatio="none">
                <path fill="white"
                    d="M0,224L60,208C120,192,240,160,360,154.7C480,149,600,171,720,181.3C840,192,960,192,1080,176C1200,160,1320,128,1380,112L1440,96V320H0Z">
                </path>
            </svg>
        </div>
    </div>


    <!-- KONTEN BAWAH -->
    <div class="px-32 py-16">

        <!-- LATAR BELAKANG -->
        <h2 class="text-2xl font-bold text-cyan-900 mb-3 reveal reveal-up delay-200">
            Latar Belakang
        </h2>

        <p class="text-slate-600 leading-relaxed max-w-5xl reveal reveal-up delay-300">
            Perpustakaan Digital merupakan sistem berbasis web yang dikembangkan untuk mempermudah 
            proses pengelolaan dan peminjaman buku secara online. Melalui pemanfaatan teknologi digital, 
            perpustakaan tidak hanya berfungsi sebagai tempat penyimpanan buku, tetapi juga sebagai sarana 
            pembelajaran modern yang mendukung peningkatan literasi dan minat baca. Dengan adanya sistem 
            SMARTELLIB, diharapkan pengguna dapat mengakses sumber pengetahuan secara lebih luas, cepat, 
            dan terstruktur.
        </p>


        <!-- VISI & MISI -->
        <div class="grid grid-cols-2 gap-12 mt-16">

            <!-- VISI -->
            <div class="
                bg-gradient-to-br from-cyan-200/70 via-cyan-100/50 to-white/60
                rounded-2xl 
                p-10 
                shadow-lg
                border border-white/50
                backdrop-blur-md
                transition duration-300
                hover:scale-[1.02]
                hover:shadow-xl
                reveal reveal-up delay-400
            "> 

                <h3 class="text-2xl font-bold text-center text-cyan-900 mb-4">
                    VISI
                </h3>
                <p class="pl-6 text-gray-700 leading-normal space-y-3">
                        Menjadi sistem perpustakaan digital berbasis web yang cerdas, 
                        mudah diakses, dan terpercaya dalam mendukung peningkatan minat baca 
                        serta kualitas literasi masyarakat.
                </p>
            </div>

            <!-- MISI -->
            <div class="
                bg-gradient-to-br from-cyan-200/70 via-cyan-100/50 to-white/60
                rounded-2xl 
                p-10 
                shadow-lg
                border border-white/50
                backdrop-blur-md
                transition duration-300
                hover:scale-[1.02]
                hover:shadow-xl
                reveal reveal-up delay-500
            ">

                <h3 class="text-2xl font-bold text-center text-cyan-900 mb-4">
                    MISI
                </h3>

                <ul class="list-disc list-outside pl-6 text-gray-700 leading-normal space-y-3">
                    <li>Menyediakan layanan perpustakaan digital berbasis web yang mudah digunakan dan dapat diakses kapan saja.</li>
                    <li>Mempermudah pengguna dalam mencari, membaca, dan meminjam buku digital secara cepat dan efisien.</li>
                    <li>Mendukung pengelolaan koleksi dan peminjaman buku secara terstruktur dan terintegrasi.</li>
                    <li>Meningkatkan minat baca melalui penyediaan koleksi buku digital yang relevan dan berkualitas.</li>
                </ul>
            </div>

        </div>
    </div>

</section>

<footer class="relative px-20 py-12 overflow-hidden">

    <!-- BACKGROUND GLASS HIJAU -->
    <div class="absolute inset-0 
        bg-gradient-to-r from-cyan-100 via-cyan-100/40 to-cyan-100
        backdrop-blur-xl
        border-t border-white/40">
    </div>

    <div class="relative z-10 text-gray-800">

        <div class="grid md:grid-cols-4 gap-12 items-start">

            <!-- KOLOM 1 - LOGO -->
            <div class="space-y-4">

                <img src="{{ asset('/img/logo.png') }}" 
                    alt="Logo Smartellib" 
                    class="w-44 object-contain drop-shadow-2xl
                            hover:opacity-90 transition
                    ">

                <p class="text-sm text-gray-700 leading-relaxed max-w-xs">
                    SMARTELLIB membantu perpustakaan mengelola koleksi buku,
                    peminjaman, dan laporan secara efisien, aman, dan terpusat.
                </p>

            </div>

            <!-- NAVIGASI -->
            <div>
                <h3 class="font-semibold mt-4 mb-6 text-lg text-gray-900">Navigasi</h3>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li><a href="#beranda" class="hover:text-cyan-600 transition">Beranda</a></li>
                    <li><a href="#tentang" class="hover:text-cyan-600 transition">Tentang Kami</a></li>
                    <li><a href="#kategori" class="hover:text-cyan-600 transition">Kategori Buku</a></li>
                    <li><a href="#fitur" class="hover:text-cyan-600 transition">Fitur</a></li>
                </ul>
            </div>

            <!-- LAYANAN -->
            <div>
                <h3 class="font-semibold mt-4 mb-6 text-lg text-gray-900">Layanan</h3>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li>Pencarian Buku</li>
                    <li>Peminjaman Digital</li>
                    <li>Pengembalian Buku</li>
                    <li>Laporan Peminjaman</li>
                    <li>Manajemen Akun</li>
                </ul>
            </div>

            <!-- KONTAK -->
            <div>
                <h3 class="font-semibold mt-4 mb-6 text-lg text-gray-900">Kontak</h3>

                <div class="space-y-3 text-sm text-gray-700">

                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-cyan-700">
                            <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                            <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                        </svg>
                        <span>smartellib@gmail.com</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-cyan-700">
                        <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z" clip-rule="evenodd" />
                        </svg>
                        <span>+62 821-6465-4250</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-cyan-700">
                            <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                        </svg>
                        <span>Perpustakaan Digital SMARTELLIB</span>
                    </div>

                </div>

                <div class="flex gap-2 mt-6">

                    <a href="#" class=" p-2 rounded-full hover:scale-110 transition">
                        <img src="{{ asset('img/instagram.png') }}" 
                            alt="Instagram" 
                            class="w-12 h-12 object-contain">
                    </a>

                    <a href="#" class=" p-2 rounded-full hover:scale-110 transition">
                        <img src="{{ asset('img/facebook.png') }}" 
                            alt="Facebook" 
                            class="w-12 h-12 object-contain">
                    </a>

                    <a href="#" class=" p-2 rounded-full hover:scale-110 transition">
                        <img src="{{ asset('img/twitter.png') }}" 
                            alt="Twitter" 
                            class="w-12 h-12 object-contain">
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-white/40 mt-6 -mb-6 flex flex-col md:flex-row justify-between items-center text-sm text-gray-700">
            <p>© {{ date('Y') }} SMARTELLIB. All rights reserved.</p>
            <div class="flex gap-4 mt-3">
                <a href="#" class="hover:text-cyan-700 transition">Privacy Policy</a>
                <span>-</span>
                <a href="#" class="hover:text-cyan-700 transition">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

<script>
    const navbarScroll = document.getElementById("navbarScroll");
    const berandaSection = document.getElementById("beranda");

    window.addEventListener("scroll", function () {
        const berandaHeight = berandaSection.offsetHeight;

        if (window.scrollY > berandaHeight - 100) {
            navbarScroll.classList.remove("-translate-y-full");
        } else {
            navbarScroll.classList.add("-translate-y-full");
        }
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {

    const animationMap = {
        "reveal-left": "animate-slideLeft",
        "reveal-right": "animate-slideRight",
        "reveal-up": "animate-slideUp",
        "reveal-scale": "animate-scaleIn"
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;

            for (let key in animationMap) {
                if (entry.target.classList.contains(key)) {
                    entry.target.classList.add(animationMap[key]);
                    break;
                }
            }

            observer.unobserve(entry.target);
        });
    }, { threshold: 0.2 });

    document.querySelectorAll(".reveal")
        .forEach(el => observer.observe(el));

});
</script>

</body>
</html>

