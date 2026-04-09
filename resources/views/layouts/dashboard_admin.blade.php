<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-slate-100 font-[Poppins]">

<div class="min-h-screen flex flex-col">

    <!-- ================= HEADER ================= -->
    <div class="h-24 bg-cyan-900/80 backdrop-blur-md border-b border-cyan-300 px-12 flex items-center justify-between relative z-50">

        <div class="flex items-center gap-6 ml-72 mt-6">
            <h2 class="text-3xl font-bold text-white">
                @yield('header')
            </h2>
        </div>

        <!-- PROFILE DROPDOWN -->
        <div class="relative">

            <button id="adminProfileBtn" class="flex items-center gap-3 focus:outline-none">
                <img src="{{ asset('/img/pp.jpg') }}"
                    class="w-10 h-10 rounded-full object-cover border-2 border-white/50">

                <svg id="adminProfileIcon"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 text-white transition-all duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)]"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- PROFILE DROPDOWN -->
            <div 
            id="adminProfileDropdown"
            class="absolute right-0 mt-4 w-[350px]
            bg-white rounded-2xl shadow-xl border p-3
            origin-top transform scale-y-0 opacity-0 -translate-y-2
            transition-all duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)]">

                <div class="bg-gradient-to-r from-cyan-800 to-cyan-700 rounded-b-2xl p-5 text-white flex items-center gap-4">

                    <div class="relative">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-cyan-500 to-cyan-600 flex items-center justify-center text-xl font-semibold">
                            AD
                        </div>

                        <div class="absolute -bottom-1 -right-1 w-7 h-7 bg-white rounded-full flex items-center justify-center shadow">
                            <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 text-cyan-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor">
                                <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M10.325 4.317
                                c.426-1.756 2.924-1.756
                                3.35 0a1.724 1.724 0 002.573 1.066
                                c1.543-.94 3.31.826
                                2.37 2.37a1.724 1.724 0 001.065 2.572
                                c1.756.426 1.756 2.924
                                0 3.35a1.724 1.724 0 00-1.066 2.573
                                c.94 1.543-.826 3.31
                                -2.37 2.37a1.724 1.724 0 00-2.572 1.065
                                c-.426 1.756-2.924 1.756
                                -3.35 0a1.724 1.724 0 00-2.573-1.066
                                c-1.543.94-3.31-.826
                                -2.37-2.37a1.724 1.724 0 00-1.065-2.572
                                c-1.756-.426-1.756-2.924
                                0-3.35a1.724 1.724 0 001.066-2.573
                                c-.94-1.543.826-3.31
                                2.37-2.37.996.608
                                2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 12a3 3 0 11-6 0
                                3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>

                    <div>
                        <div class="font-semibold text-lg leading-tight">
                            {{ auth()->user()->nama ?? 'Petugas' }}
                        </div>

                        <div class="text-xs flex items-center gap-2 opacity-90 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor">
                                <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75
                                m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25
                                m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615
                                a2.25 2.25 0 0 1-2.36 0L3.32 8.91
                                a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
                            </svg>

                            {{ auth()->user()->email ?? 'petugas@email.com' }}
                        </div>

                        <button class="mt-3 bg-white text-cyan-600 text-sm font-medium px-4 py-1.5 rounded-full hover:bg-cyan-100 transition">
                            Lihat Profil
                        </button>
                    </div>
                </div>

                <div class="border-t mt-5"></div>

                <div class="flex justify-center mt-4">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit"
                            class="flex items-center gap-3 bg-cyan-100 hover:bg-cyan-200 px-5 py-2.5 rounded-full transition">

                            <div class="w-8 h-8 rounded-full bg-cyan-600 text-white flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                </svg>
                            </div>

                            <span class="text-sm text-gray-700">
                                Keluar
                            </span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- ================= BODY ================= -->
    <div class="flex flex-1 px-6">

        <!-- ================= SIDEBAR ================= -->
        <aside class="w-72 bg-cyan-900/80 backdrop-blur-md shadow-xl rounded-t-3xl min-h-[calc(100vh-6rem)] -mt-16 z-50 flex flex-col">

            <div class="pt-4 text-center">
                <img src="{{ asset('/img/logo.png') }}"
                    class="w-40 mx-auto mb-6">
            </div>

            <div class="pb-6 text-center">
                <img src="{{ asset('/img/pp.jpg') }}"
                    class="w-24 h-24 rounded-full mx-auto mb-4 object-cover border-2 border-white/40">

                <h2 class="font-semibold text-white text-lg mb-2">
                    Admin
                </h2>

                <span class="text-sm bg-white/30 px-10 py-1 rounded-full text-white">
                    Admin
                </span>
            </div>

            <div class="p-6 space-y-2 text-white flex-1" id="sidebarMenu">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link block px-4 py-3 rounded-xl font-medium transition-all duration-500 ease-in-out">
                    Dashboard
                </a>

                <a href="{{ route('admin.petugas.index') }}" class="sidebar-link block px-4 py-3 rounded-xl font-medium transition-all duration-500 ease-in-out">
                    Manajemen Petugas
                </a>

                <a href="{{ route('admin.kategori.index') }}"
                    class="sidebar-link block px-4 py-3 rounded-xl font-medium transition-all duration-500 ease-in-out">
                    Manajemen Kategori Buku
                </a>

                <a href="{{ route('admin.anggota.index') }}"
                    class="sidebar-link block px-4 py-3 rounded-xl font-medium transition-all duration-500 ease-in-out">
                    Daftar Anggota
                </a>

                <a href="{{ route('admin.buku.index') }}" class="sidebar-link block px-4 py-3 rounded-xl font-medium transition-all duration-500 ease-in-out">
                    Daftar Buku
                </a>

                <a href="{{ route('admin.laporan.index') }}" class="sidebar-link block px-4 py-3 rounded-xl font-medium transition-all duration-500 ease-in-out">
                    Manajemen Laporan
                </a>

                <a href="{{ route('admin.pengaturan.index') }}" class="sidebar-link block px-4 py-3 rounded-xl font-medium transition-all duration-500 ease-in-out">
                    Pengaturan Sistem
                </a>
            </div>
        </aside>

        <!-- ================= CONTENT ================= -->
        <main class="flex-1 pt-10 pl-8 pb-10">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>