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

                    @if($user->photo)
                        <img 
                            src="{{ asset('storage/'.$user->photo) }}"
                            class="
                                w-28 h-28 rounded-full object-cover
                                ring-2 ring-cyan-300/40
                                shadow-[0_0_12px_rgba(34,211,238,0.45)]
                                hover:scale-105
                                hover:shadow-[0_0_18px_rgba(34,211,238,0.65)]
                                transition duration-300
                                mt-6
                            "
                        >
                    @else
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
                            {{ strtoupper(substr($user->nama ?? 'IM',0,2)) }}
                        </div>
                    @endif

                </div>

                <!-- NAMA -->
                <h2 class="mt-5 text-xl font-semibold text-gray-800">
                    {{ $user->nama }}
                </h2>

                <div class="mt-2 text-sm text-gray-500 space-y-1">
                    <p>{{ $user->email }}</p>
                    <p>{{ $user->anggota?->no_hp ?? '-' }}</p>
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

                        @forelse($ulasan as $item)
                        <div class="bg-white rounded-2xl shadow p-6">
                            <div class="flex gap-4">

                                <div class="w-10 h-10 bg-cyan-500 text-white flex items-center justify-center rounded-full text-sm">
                                    {{ strtoupper(substr($user->nama,0,2)) }}
                                </div>

                                <div class="flex-1">

                                    <p class="font-semibold text-sm">
                                        {{ $user->nama }}
                                    </p>

                                    <p class="text-xs text-gray-500">
                                        Memberikan ulasan • {{ $item->created_at->format('d M Y') }}
                                    </p>

                                    <p class="text-sm mt-2 text-gray-700">
                                        {{ $item->comment }}
                                    </p>

                                    <!-- BUKU -->
                                    <div class="flex gap-4 mt-4">
                                        <img src="{{ $item->buku->cover 
                                            ? asset('storage/'.$item->buku->cover) 
                                            : 'https://via.placeholder.com/100' }}"
                                            class="w-24 rounded shadow">

                                        <div>
                                            <p class="font-semibold text-sm">
                                                {{ $item->buku->judul }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $item->buku->penulis }}
                                            </p>

                                            @php
                                                $rating = round($item->rating?->rating ?? 0);
                                            @endphp

                                            <div class="flex text-yellow-400 text-sm mt-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $rating)
                                                        ★
                                                    @else
                                                        <span class="text-gray-300">★</span>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        @empty
                            <div class="col-span-full flex justify-center items-center py-20">
                                <p class="text-gray-500 text-center">
                                    Belum ada ulasan.
                                </p>
                            </div>
                        @endforelse

                    </div>


                    <!-- ================= RIWAYAT ================= -->
                    <div class="w-full flex-none isolate min-h-[420px]">

                        <div class="w-full px-6 py-6">
                            <div class="max-w-7xl mx-auto">

                                <div id="bookContainerRiwayat"
                                    class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-10">

                                    <!-- CARD -->
                                    @forelse($riwayat as $item)
                                    <a href="#" class="book-card group block cursor-pointer">

                                        <div class="relative rounded-xl overflow-hidden shadow-sm
                                            transition-all duration-500 group-hover:-translate-y-3 group-hover:shadow-xl">

                                            <img src="{{ $item->buku->cover 
                                                ? asset('storage/'.$item->buku->cover) 
                                                : 'https://via.placeholder.com/150' }}"
                                                class="w-full aspect-[2/3] object-cover">

                                        </div>

                                        <h3 class="mt-3 text-sm font-semibold text-gray-800">
                                            {{ $item->buku->judul }}
                                        </h3>

                                        <p class="text-xs text-gray-500">
                                            {{ $item->buku->penulis }}
                                        </p>

                                        <p class="text-sm mt-2 text-gray-500">
                                            {{ ucfirst($item->jenis_aktivitas) }} • 
                                            {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('d M Y') }}
                                        </p>

                                    </a>

                                    @empty
                                        <div class="col-span-full flex justify-center items-center py-20">
                                            <p class="text-gray-500 text-center">
                                                Belum ada riwayat peminjaman
                                            </p>
                                        </div>
                                    @endforelse

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