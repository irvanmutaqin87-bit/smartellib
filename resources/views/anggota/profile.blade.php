@extends('layouts.app')

@section('title','Profile - SMARTELLIB')

@section('content')

<section class="bg-gray-50 py-16 flex justify-center">
    <div class="w-full max-w-5xl">

        <!-- ================= HEADER PROFILE ================= -->
        <section class="rounded-2xl shadow-2xl overflow-hidden">

            <div class="text-center p-12 bg-gradient-to-br from-cyan-50 to-white">

                <!-- AVATAR -->
                <div class="relative w-28 mx-auto">

                    <div
                        class="
                        w-28 h-28 rounded-full
                        bg-gradient-to-br from-cyan-400 to-cyan-500
                        text-white font-semibold text-3xl
                        flex items-center justify-center
                        ring-2 ring-cyan-300/40
                        shadow-[0_0_12px_rgba(34,211,238,0.45)]
                        hover:scale-105
                        hover:shadow-[0_0_18px_rgba(34,211,238,0.65)]
                        transition duration-300
                        mt-6
                    ">
                        {{ strtoupper(substr(auth()->user()->name ?? 'IM',0,2)) }}
                    </div>

                    <!-- CAMERA -->
                    <label
                        class="
                        absolute bottom-0 right-0
                        w-9 h-9 rounded-full
                        bg-white
                        flex items-center justify-center
                        cursor-pointer
                        ring-2 ring-cyan-300/40
                        shadow-[0_0_12px_rgba(34,211,238,0.45)]
                        hover:scale-105
                        hover:shadow-[0_0_18px_rgba(34,211,238,0.65)]
                        transition duration-300
                    ">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 text-cyan-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 7h4l2-2h6l2 2h4v12H3z"/>

                            <circle cx="12" cy="13" r="4"
                                stroke="currentColor"
                                stroke-width="2"/>
                        </svg>

                        <input type="file" class="hidden">
                    </label>

                </div>

                <!-- NAMA -->
                <h2 class="mt-5 text-xl font-semibold text-gray-800">
                    {{ auth()->user()->name ?? 'Irvan Mutaqin' }}
                </h2>

                <!-- EMAIL & HP -->
                <div class="mt-2 text-sm text-gray-500 space-y-1">
                    <p>{{ auth()->user()->email ?? 'irvan@email.com' }}</p>
                    <p>+62 812-3456-7890</p>
                </div>

                <!-- TAB -->
                <div class="mt-10">
                    <div class="relative flex justify-center gap-12 border-b pb-3">

                        <button onclick="switchTab(0)"
                            class="tab-link text-gray-500 hover:text-cyan-600">
                            Ulasan Buku
                        </button>

                        <button onclick="switchTab(1)"
                            class="tab-link text-gray-500 hover:text-cyan-600">
                            Riwayat Buku
                        </button>

                        <span id="tabIndicator"
                            class="absolute bottom-0 h-[2px] bg-cyan-500 transition-all duration-300">
                        </span>
                    </div>
                </div>

            </div>
        </section>


        <!-- ================= CONTENT ================= -->
        <div class="mt-10">

            <div class="overflow-hidden">
                <div id="tabContent"
                    class="flex transition-transform duration-500 will-change-transform w-full">

                    <!-- ================= ULASAN ================= -->
                    <div class="w-full flex-none py-6 space-y-6 isolate min-h-[420px] overflow-hidden">

                        <div class="bg-white rounded-2xl shadow p-6">
                            <div class="flex gap-4">

                                <div class="w-10 h-10 bg-cyan-500 text-white flex items-center justify-center rounded-full text-sm">
                                    IM
                                </div>

                                <div class="flex-1">

                                    <p class="font-semibold text-sm">Irvan Mutaqin</p>
                                    <p class="text-xs text-gray-500">
                                        Memberikan rating dan ulasan • 15 Maret 2026
                                    </p>

                                    <p class="text-sm mt-2 text-gray-700">
                                        Buku ini sangat menarik dan inspiratif.
                                    </p>

                                    <!-- BUKU -->
                                    <div class="flex gap-4 mt-4">
                                        <img src="https://covers.openlibrary.org/b/isbn/9780062316097-L.jpg"
                                            class="w-24 rounded shadow">

                                        <div>
                                            <p class="font-semibold text-sm">Bagaimana Saya Menulis</p>
                                            <p class="text-xs text-gray-500">Bertrand Russell</p>
                                            <p class="text-yellow-400 text-sm mt-1">★★★★★ 4.7</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>


                    <!-- ================= RIWAYAT ================= -->
                    <div class="w-full flex-none isolate min-h-[420px]">

                        <div class="w-full px-6 py-6">
                            <div class="max-w-7xl mx-auto">

                                <div id="bookContainerRiwayat"
                                    class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-10">

                                    <!-- CARD -->
                                    <a href="#" class="book-card group block cursor-pointer opacity-0 translate-y-6 transition-all duration-500 transform-gpu">

                                        <div class="relative rounded-xl overflow-hidden shadow-sm
                                                    transition-all duration-500 transform-gpu
                                                    group-hover:-translate-y-3 group-hover:shadow-xl">

                                            <div class="absolute inset-0 bg-gradient-to-t
                                                from-black/10 via-transparent to-transparent
                                                opacity-0 group-hover:opacity-100 transition">
                                            </div>

                                            <img src="https://covers.openlibrary.org/b/isbn/9780062316097-L.jpg"
                                                class="w-full aspect-[2/3] object-cover
                                                transition duration-500 group-hover:scale-105" />

                                        </div>

                                        <h3 class="mt-3 text-sm font-semibold text-gray-800">Sapiens</h3>
                                        <p class="text-xs text-gray-500">Yuval Noah Harari</p>

                                    </a>

                                    <!-- DUPLIKASI -->
                                    <a href="#" class="book-card group block cursor-pointer opacity-0 translate-y-6 transition-all duration-500 transform-gpu">
                                        <div class="relative rounded-xl overflow-hidden shadow-sm transition-all duration-500 group-hover:-translate-y-3 group-hover:shadow-xl">
                                            <img src="https://covers.openlibrary.org/b/isbn/9780062316097-L.jpg"
                                                class="w-full aspect-[2/3] object-cover transition duration-500 group-hover:scale-105" />
                                        </div>
                                        <h3 class="mt-3 text-sm font-semibold text-gray-800">Sapiens</h3>
                                        <p class="text-xs text-gray-500">Yuval Noah Harari</p>
                                    </a>

                                    <a href="#" class="book-card group block cursor-pointer opacity-0 translate-y-6 transition-all duration-500 transform-gpu">
                                        <div class="relative rounded-xl overflow-hidden shadow-sm transition-all duration-500 group-hover:-translate-y-3 group-hover:shadow-xl">
                                            <img src="https://covers.openlibrary.org/b/isbn/9780062316097-L.jpg"
                                                class="w-full aspect-[2/3] object-cover transition duration-500 group-hover:scale-105" />
                                        </div>
                                        <h3 class="mt-3 text-sm font-semibold text-gray-800">Sapiens</h3>
                                        <p class="text-xs text-gray-500">Yuval Noah Harari</p>
                                    </a>

                                    <a href="#" class="book-card group block cursor-pointer opacity-0 translate-y-6 transition-all duration-500 transform-gpu">
                                        <div class="relative rounded-xl overflow-hidden shadow-sm transition-all duration-500 group-hover:-translate-y-3 group-hover:shadow-xl">
                                            <img src="https://covers.openlibrary.org/b/isbn/9780062316097-L.jpg"
                                                class="w-full aspect-[2/3] object-cover transition duration-500 group-hover:scale-105" />
                                        </div>
                                        <h3 class="mt-3 text-sm font-semibold text-gray-800">Sapiens</h3>
                                        <p class="text-xs text-gray-500">Yuval Noah Harari</p>
                                    </a>

                                    <a href="#" class="book-card group block cursor-pointer opacity-0 translate-y-6 transition-all duration-500 transform-gpu">
                                        <div class="relative rounded-xl overflow-hidden shadow-sm transition-all duration-500 group-hover:-translate-y-3 group-hover:shadow-xl">
                                            <img src="https://covers.openlibrary.org/b/isbn/9780062316097-L.jpg"
                                                class="w-full aspect-[2/3] object-cover transition duration-500 group-hover:scale-105" />
                                        </div>
                                        <h3 class="mt-3 text-sm font-semibold text-gray-800">Sapiens</h3>
                                        <p class="text-xs text-gray-500">Yuval Noah Harari</p>
                                    </a>

                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>
</section>

@endsection