@extends('layouts.app')

@section('title','Notifikasi - SMARTELLIB')

@section('content')

<section class="bg-gray-50 py-12 flex justify-center">

<div class="w-full max-w-3xl space-y-6">

    <!-- ================= LOOP NOTIFIKASI ================= -->
    @forelse($notifs ?? [1,2] as $notif)

    <div class="bg-white rounded-2xl shadow-xl p-6 relative">

        <!-- ================= MENU TITIK 3 ================= -->
        <div class="absolute right-5 top-5">

            <button class="notifMenuButton p-2 rounded-full hover:bg-gray-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 text-gray-500"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <circle cx="5" cy="12" r="1.5"/>
                    <circle cx="12" cy="12" r="1.5"/>
                    <circle cx="19" cy="12" r="1.5"/>
                </svg>
            </button>

            <!-- DROPDOWN -->
            <div class="notifDropdown absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-lg border
                origin-top transform scale-y-0 opacity-0 -translate-y-2 pointer-events-none
                transition-all duration-300 ease-out">

                <button class="markRead w-full text-left px-4 py-2 text-sm hover:bg-gray-50">
                    <!-- Icon Heroicons Check Circle -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block mr-2 text-cyan-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                    Tandai Dibaca
                </button>

                <button class="deleteNotif w-full text-left px-4 py-2 text-sm hover:bg-gray-50 text-red-500">
                    <!-- Icon Heroicons Trash -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block mr-2 text-red-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
                    Hapus
                </button>

            </div>

        </div>

        <!-- ================= HEADER ================= -->
        <div class="flex items-start gap-4 mb-4">

            <!-- ICON -->
            <div class="w-12 h-12 rounded-full bg-cyan-100 flex items-center justify-center">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6 text-cyan-600"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M15 17h5l-1.405-1.405M19 17V9a7 7 0 10-14 0v8l-1.405 1.405M5 17h5"/>
                </svg>

            </div>

            <!-- TITLE -->
            <div class="flex-1">
                <h1 class="text-base font-semibold text-gray-800">
                    Buku hampir jatuh tempo
                </h1>

                <p class="text-xs text-gray-500 mt-1">
                    22 Maret 2026 • 14:32 WIB
                </p>
            </div>

        </div>

        <!-- ================= BADGE ================= -->
        <div class="mb-4">
            <span class="text-xs px-3 py-1 rounded-full bg-yellow-100 text-yellow-600">
                Pengingat
            </span>
        </div>

        <!-- ================= ISI ================= -->
        <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-700 leading-relaxed">

            Buku <b>"Lord Of The Rings"</b> akan segera habis masa pinjam.

        </div>

        <!-- ================= ACTION ================= -->
        <div class="flex gap-3 mt-5">

            <a href="#"
                class="px-4 py-2 rounded-full bg-cyan-500 text-white text-sm hover:bg-cyan-600 transition">
                Lihat Buku
            </a>

        </div>

    </div>

    @empty
    <div class="text-center text-gray-400 text-sm">
        Tidak ada notifikasi
    </div>
    @endforelse

</div>

</section>

@endsection