@extends('layouts.app')

@section('title','Beranda - SMARTELLIB')

@section('content')

<section class="max-w-6xl mx-auto mt-24">

    <div class="relative flex justify-center items-center">

        <!-- BUTTON LEFT -->
        <button
            onclick="prevSlide()"
            class="absolute left-[15%] z-20
            bg-cyan-200/10
            border border-cyan-400/40
            p-3 rounded-full
            hover:bg-cyan-200/20
            hover:scale-110
            transition duration-300"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 19.5L8.25 12l7.5-7.5"/>
            </svg>
        </button>

        <!-- CAROUSEL -->
        <div class="relative w-[700px] h-[420px] flex items-center justify-center perspective">

            <!-- LEFT BOOK -->
            <div id="leftCard" class="absolute transition-all duration-700 ease-[cubic-bezier(.22,.61,.36,1)] opacity-60 blur-[1px]">
                <a id="leftLink" href="#">
                    <img id="leftImg" class="w-44 aspect-[2/3] object-cover rounded-xl shadow-xl transition">
                </a>
            </div>

            <!-- CENTER BOOK -->
            <div id="centerCard" class="absolute z-10 transition-all duration-700 ease-[cubic-bezier(.22,.61,.36,1)]">
                <a id="centerLink" href="#">
                    <img id="centerImg" class="w-52 aspect-[2/3] object-cover rounded-xl shadow-2xl transition">
                </a>

                <h3 id="bookTitle" class="text-center mt-4 font-semibold text-sm"></h3>
                <p id="bookAuthor" class="text-center text-xs text-gray-500"></p>
            </div>

            <!-- RIGHT BOOK -->
            <div id="rightCard" class="absolute transition-all duration-700 ease-[cubic-bezier(.22,.61,.36,1)] opacity-60 blur-[1px]">
                <a id="rightLink" href="#">
                    <img id="rightImg" class="w-44 aspect-[2/3] object-cover rounded-xl shadow-xl transition">
                </a>
            </div>

        </div>

        <!-- BUTTON RIGHT -->
        <button
            onclick="nextSlide()"
            class="absolute right-[15%] z-20
            bg-cyan-200/10
            border border-cyan-200/40
            p-3 rounded-full
            hover:bg-cyan-200/20
            hover:scale-110
            transition duration-300"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
            </svg>
        </button>

    </div>

</section>

<style>
    .perspective {
        perspective: 1200px;
    }
</style>

<main class="max-w-7xl mx-auto px-24 py-16">

    <div class="flex items-center justify-between mb-10">
        <h2 class="text-lg font-medium text-gray-700 tracking-wide">
            Rekomendasi Buku
        </h2>
        <a href="{{ route('anggota.buku.index') }}"
            class="text-cyan-500 text-sm font-medium hover:text-cyan-600 transition">
            Baca Selengkapnya
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-10">
        @forelse($rekomendasiBooks as $buku)
            <a href="{{ route('anggota.buku.detail', $buku->id) }}"
               class="group cursor-pointer book-card opacity-0 translate-y-6 block">

                <div class="relative overflow-hidden rounded-xl shadow-[0_6px_18px_rgba(0,0,0,0.08)] transition-all duration-500 group-hover:-translate-y-3 group-hover:shadow-[0_20px_45px_rgba(0,0,0,0.20)]">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/10 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                    <img
                        src="{{ $buku->cover ? asset('storage/' . $buku->cover) : 'https://via.placeholder.com/300x450?text=No+Cover' }}"
                        class="w-full aspect-[2/3] object-cover brightness-110 contrast-110 transition duration-500 group-hover:scale-105 group-hover:brightness-115"
                        alt="{{ $buku->judul }}"
                    />
                </div>

                <h3 class="mt-3 text-sm font-semibold text-gray-800 line-clamp-2">
                    {{ $buku->judul }}
                </h3>

                <p class="text-xs text-gray-500">
                    {{ $buku->penulis }}
                </p>

                <div class="flex items-center gap-2 mt-2">
                    <div class="flex text-yellow-400 text-sm">
                        @php $avg = round($buku->average_rating ?? 0); @endphp
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $avg)
                                ★
                            @else
                                <span class="text-gray-300">★</span>
                            @endif
                        @endfor
                    </div>
                    <span class="text-xs text-gray-500">
                        {{ number_format($buku->average_rating ?? 0, 1) }}
                    </span>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center text-gray-500 py-10">
                Belum ada buku rekomendasi.
            </div>
        @endforelse
    </div>
</main>

<section class="max-w-6xl mx-auto px-24 py-16">
    <h2 class="text-center text-2xl mb-14">
        Buku Teratas
    </h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-x-16 gap-y-20 justify-center">
        @forelse($bukuTeratas as $index => $buku)
            <a href="{{ route('anggota.buku.detail', $buku->id) }}"
               class="{{ $index >= 4 ? 'col-span-2 md:col-span-1' : '' }} group w-40 text-center cursor-pointer book-card opacity-0 translate-y-6 block mx-auto">

                <div class="relative overflow-hidden rounded-lg shadow-md transition duration-500 group-hover:shadow-xl group-hover:-translate-y-2">
                    <img
                        src="{{ $buku->cover ? asset('storage/' . $buku->cover) : 'https://via.placeholder.com/300x450?text=No+Cover' }}"
                        class="w-full aspect-[2/3] object-cover brightness-105 contrast-105 transition duration-500 group-hover:scale-105 group-hover:brightness-110"
                        alt="{{ $buku->judul }}"
                    >
                </div>

                <h3 class="mt-4 text-base font-medium text-gray-800 line-clamp-2">
                    {{ $buku->judul }}
                </h3>

                <p class="text-sm text-gray-500">
                    {{ $buku->penulis }}
                </p>

                <div class="flex justify-center items-center gap-2 mt-2">
                    <div class="flex text-yellow-400 text-sm">
                        @php $avg = round($buku->average_rating ?? 0); @endphp
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $avg)
                                ★
                            @else
                                <span class="text-gray-300">★</span>
                            @endif
                        @endfor
                    </div>
                    <span class="text-xs text-gray-500">
                        {{ number_format($buku->average_rating ?? 0, 1) }}
                    </span>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center text-gray-500 py-10">
                Belum ada buku teratas.
            </div>
        @endforelse
    </div>
</section>

{{-- DATA UNTUK JS CAROUSEL --}}
@php
    $carouselBooksData = $carouselBooks->map(function ($buku) {
        return [
            'id' => $buku->id,
            'title' => $buku->judul,
            'author' => $buku->penulis,
            'image' => $buku->cover 
                ? asset('storage/' . $buku->cover) 
                : 'https://via.placeholder.com/300x450?text=No+Cover',
            'url' => route('anggota.buku.detail', $buku->id),
        ];
    })->values();
@endphp

<script>
    window.carouselBooks = @json($carouselBooksData);
</script>

@endsection