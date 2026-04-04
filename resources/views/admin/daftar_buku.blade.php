@extends('layouts.dashboard_admin')

@section('title', 'Daftar Buku - SMARTELLIB')

@section('header')
<span class="text-2xl font-semibold">Daftar Buku</span>
@endsection

@section('content')
<div class="flex-1 overflow-y-auto flex flex-col">

    <!-- Page Header -->
    <div class="bg-gray-200 px-8 py-5 border-b border-gray-300 rounded-xl mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Daftar Buku</h2>
        <p class="text-sm text-gray-500 mt-0.5">Kelola daftar buku perpustakaan</p>
    </div>

    <div class="p-6 bg-white rounded-2xl shadow-sm">

        <!-- Filter + Tambah -->
        <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
            <div class="flex gap-2 flex-wrap" id="filterBtns">
                <button class="filter-btn active px-5 py-2 rounded-full text-sm font-semibold bg-blue-600 text-white border border-blue-600 transition">
                    Semua
                </button>
                <button class="filter-btn px-5 py-2 rounded-full text-sm font-medium bg-white text-gray-700 border border-gray-300 hover:border-blue-400 transition">
                    Novel
                </button>
                <button class="filter-btn px-5 py-2 rounded-full text-sm font-medium bg-white text-gray-700 border border-gray-300 hover:border-blue-400 transition">
                    Drama
                </button>
                <button class="filter-btn px-5 py-2 rounded-full text-sm font-medium bg-white text-gray-700 border border-gray-300 hover:border-blue-400 transition">
                    Pemrograman
                </button>
                <button class="filter-btn px-5 py-2 rounded-full text-sm font-medium bg-white text-gray-700 border border-gray-300 hover:border-blue-400 transition">
                    Sains
                </button>
            </div>

            <button
                class="flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold px-5 py-2.5 rounded-lg text-sm shadow-sm transition whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Buku
            </button>
        </div>

        <!-- Book Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">

            <!-- Card 1 -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                <div class="bg-gradient-to-br from-cyan-400 to-blue-500 h-44 flex flex-col items-center justify-center relative">
                    <svg class="w-12 h-12 text-white/70 mb-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                    </svg>
                    <p class="text-white font-semibold text-sm px-4 text-center leading-tight">Laskar Pelangi</p>

                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                        <button class="px-3 py-1.5 bg-white text-blue-600 text-xs font-semibold rounded-lg hover:bg-blue-50 transition">
                            Edit
                        </button>
                        <button class="px-3 py-1.5 bg-white text-red-500 text-xs font-semibold rounded-lg hover:bg-red-50 transition">
                            Hapus
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <p class="font-semibold text-gray-800 text-sm leading-snug">Laskar Pelangi</p>
                    <p class="text-xs text-gray-400 mt-0.5">Andrea Hirata</p>
                    <span class="inline-block mt-2 text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full font-medium">
                        Novel
                    </span>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                <div class="bg-gradient-to-br from-purple-400 to-purple-600 h-44 flex flex-col items-center justify-center relative">
                    <svg class="w-12 h-12 text-white/70 mb-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                    </svg>
                    <p class="text-white font-semibold text-sm px-4 text-center leading-tight">Hujan</p>

                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                        <button class="px-3 py-1.5 bg-white text-blue-600 text-xs font-semibold rounded-lg hover:bg-blue-50 transition">
                            Edit
                        </button>
                        <button class="px-3 py-1.5 bg-white text-red-500 text-xs font-semibold rounded-lg hover:bg-red-50 transition">
                            Hapus
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <p class="font-semibold text-gray-800 text-sm leading-snug">Hujan</p>
                    <p class="text-xs text-gray-400 mt-0.5">Tere Liye</p>
                    <span class="inline-block mt-2 text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full font-medium">
                        Novel
                    </span>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                <div class="bg-gradient-to-br from-violet-400 to-purple-500 h-44 flex flex-col items-center justify-center relative">
                    <svg class="w-12 h-12 text-white/70 mb-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                    </svg>
                    <p class="text-white font-semibold text-sm px-4 text-center leading-tight">Janji</p>

                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                        <button class="px-3 py-1.5 bg-white text-blue-600 text-xs font-semibold rounded-lg hover:bg-blue-50 transition">
                            Edit
                        </button>
                        <button class="px-3 py-1.5 bg-white text-red-500 text-xs font-semibold rounded-lg hover:bg-red-50 transition">
                            Hapus
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <p class="font-semibold text-gray-800 text-sm leading-snug">Janji</p>
                    <p class="text-xs text-gray-400 mt-0.5">Tere Liye</p>
                    <span class="inline-block mt-2 text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full font-medium">
                        Drama
                    </span>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                <div class="bg-gradient-to-br from-green-400 to-emerald-600 h-44 flex flex-col items-center justify-center relative">
                    <svg class="w-12 h-12 text-white/70 mb-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                    </svg>
                    <p class="text-white font-semibold text-sm px-4 text-center leading-tight">Algoritma dan Pemrograman</p>

                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                        <button class="px-3 py-1.5 bg-white text-blue-600 text-xs font-semibold rounded-lg hover:bg-blue-50 transition">
                            Edit
                        </button>
                        <button class="px-3 py-1.5 bg-white text-red-500 text-xs font-semibold rounded-lg hover:bg-red-50 transition">
                            Hapus
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <p class="font-semibold text-gray-800 text-sm leading-snug">Algoritma dan Pemrograman</p>
                    <p class="text-xs text-gray-400 mt-0.5">Lamhot Sitorus</p>
                    <span class="inline-block mt-2 text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full font-medium">
                        Pemrograman
                    </span>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                <div class="bg-gradient-to-br from-orange-400 to-red-500 h-44 flex flex-col items-center justify-center relative">
                    <svg class="w-12 h-12 text-white/70 mb-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                    </svg>
                    <p class="text-white font-semibold text-sm px-4 text-center leading-tight">Sapiens</p>

                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                        <button class="px-3 py-1.5 bg-white text-blue-600 text-xs font-semibold rounded-lg hover:bg-blue-50 transition">
                            Edit
                        </button>
                        <button class="px-3 py-1.5 bg-white text-red-500 text-xs font-semibold rounded-lg hover:bg-red-50 transition">
                            Hapus
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <p class="font-semibold text-gray-800 text-sm leading-snug">Sapiens</p>
                    <p class="text-xs text-gray-400 mt-0.5">Yuval Noah Harari</p>
                    <span class="inline-block mt-2 text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full font-medium">
                        Sejarah
                    </span>
                </div>
            </div>

            <!-- Card 6 -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                <div class="bg-gradient-to-br from-pink-400 to-rose-500 h-44 flex flex-col items-center justify-center relative">
                    <svg class="w-12 h-12 text-white/70 mb-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                    </svg>
                    <p class="text-white font-semibold text-sm px-4 text-center leading-tight">Clean Code</p>

                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                        <button class="px-3 py-1.5 bg-white text-blue-600 text-xs font-semibold rounded-lg hover:bg-blue-50 transition">
                            Edit
                        </button>
                        <button class="px-3 py-1.5 bg-white text-red-500 text-xs font-semibold rounded-lg hover:bg-red-50 transition">
                            Hapus
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <p class="font-semibold text-gray-800 text-sm leading-snug">Clean Code</p>
                    <p class="text-xs text-gray-400 mt-0.5">Robert C. Martin</p>
                    <span class="inline-block mt-2 text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full font-medium">
                        Pemrograman
                    </span>
                </div>
            </div>

            <!-- Card 7 -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                <div class="bg-gradient-to-br from-blue-400 to-indigo-600 h-44 flex flex-col items-center justify-center relative">
                    <svg class="w-12 h-12 text-white/70 mb-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                    </svg>
                    <p class="text-white font-semibold text-sm px-4 text-center leading-tight">Atomic Habits</p>

                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                        <button class="px-3 py-1.5 bg-white text-blue-600 text-xs font-semibold rounded-lg hover:bg-blue-50 transition">
                            Edit
                        </button>
                        <button class="px-3 py-1.5 bg-white text-red-500 text-xs font-semibold rounded-lg hover:bg-red-50 transition">
                            Hapus
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <p class="font-semibold text-gray-800 text-sm leading-snug">Atomic Habits</p>
                    <p class="text-xs text-gray-400 mt-0.5">James Clear</p>
                    <span class="inline-block mt-2 text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full font-medium">
                        Self Development
                    </span>
                </div>
            </div>

            <!-- Card 8 -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                <div class="bg-gradient-to-br from-teal-400 to-cyan-600 h-44 flex flex-col items-center justify-center relative">
                    <svg class="w-12 h-12 text-white/70 mb-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                    </svg>
                    <p class="text-white font-semibold text-sm px-4 text-center leading-tight">Fisika Dasar</p>

                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                        <button class="px-3 py-1.5 bg-white text-blue-600 text-xs font-semibold rounded-lg hover:bg-blue-50 transition">
                            Edit
                        </button>
                        <button class="px-3 py-1.5 bg-white text-red-500 text-xs font-semibold rounded-lg hover:bg-red-50 transition">
                            Hapus
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <p class="font-semibold text-gray-800 text-sm leading-snug">Fisika Dasar</p>
                    <p class="text-xs text-gray-400 mt-0.5">Halliday & Resnick</p>
                    <span class="inline-block mt-2 text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full font-medium">
                        Sains
                    </span>
                </div>
            </div>

        </div>

        <!-- Empty State -->
        <div class="hidden text-center py-16 text-gray-400 text-sm">
            <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
            </svg>
            Tidak ada buku ditemukan.
        </div>

    </div>
</div>
@endsection