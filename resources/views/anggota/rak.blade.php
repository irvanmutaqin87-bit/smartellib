@extends('layouts.app')

@section('title','Rak Pinjam - SMARTELLIB')

@section('content')

<section class="bg-gray-50 py-16 flex justify-center">
    <div class="w-full max-w-5xl">

        <!-- ================= HEADER ================= -->
        <section class="rounded-2xl shadow-2xl overflow-hidden">
            <div class="text-center p-12 bg-gradient-to-br from-cyan-50 to-white">

                <!-- ICON -->
                <div class="w-20 h-20 mx-auto rounded-full bg-cyan-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-cyan-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m7.875 14.25 1.214 1.942a2.25 2.25 0 0 0 1.908 1.058h2.006c.776 0 1.497-.4 1.908-1.058l1.214-1.942M2.41 9h4.636a2.25 2.25 0 0 1 1.872 1.002l.164.246a2.25 2.25 0 0 0 1.872 1.002h2.092a2.25 2.25 0 0 0 1.872-1.002l.164-.246A2.25 2.25 0 0 1 16.954 9h4.636M2.41 9a2.25 2.25 0 0 0-.16.832V12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 12V9.832c0-.287-.055-.57-.16-.832M2.41 9a2.25 2.25 0 0 1 .382-.632l3.285-3.832a2.25 2.25 0 0 1 1.708-.786h8.43c.657 0 1.281.287 1.709.786l3.284 3.832c.163.19.291.404.382.632M4.5 20.25h15A2.25 2.25 0 0 0 21.75 18v-2.625c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125V18a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                </div>

                <!-- TITLE -->
                <h2 class="mt-5 text-xl font-semibold text-gray-800">Rak Pribadi</h2>
                <p class="text-sm text-gray-500 mt-1">Aktivitas Anda akan tersimpan di halaman ini</p>

                <!-- TAB -->
                <div class="mt-10">
                    <div class="relative flex justify-center gap-12 border-b pb-3">

                        <button onclick="switchTab(0)"
                            class="tab-link text-gray-500 hover:text-cyan-600">
                            Pinjam
                        </button>

                        <button onclick="switchTab(1)"
                            class="tab-link text-gray-500 hover:text-cyan-600">
                            Antrian
                        </button>

                        <button onclick="switchTab(2)"
                            class="tab-link text-gray-500 hover:text-cyan-600">
                            Riwayat
                        </button>

                        <button onclick="switchTab(3)"
                            class="tab-link text-gray-500 hover:text-cyan-600">
                            ulasan
                        </button>

                        <span id="tabIndicator"
                            class="absolute bottom-0 h-[2px] bg-cyan-500 transition-all duration-300">
                        </span>
                    </div>
                </div>

            </div>
        </section>

        <!-- ================= CONTENT ================= -->
        <div class="mt-10 overflow-hidden">
            <div id="tabContent" class="flex transition-transform duration-500 w-full">

                <!-- ================= PINJAM ================= -->
                <div class="w-full flex-none py-6 space-y-6 isolate min-h-[420px] overflow-hidden">
                    @forelse($pinjam as $item)
                    <div class="bg-white rounded-2xl shadow p-6 flex gap-4">

                        <img src="{{ $item->buku->cover 
                            ? asset('storage/'.$item->buku->cover) 
                            : 'https://via.placeholder.com/150' }}"
                            class="w-24 h-36 rounded shadow object-cover">

                        <div class="flex-1">
                            <p class="font-semibold text-sm">
                                {{ $item->buku->judul }}
                            </p>

                            <p class="text-xs text-gray-500">
                                {{ $item->buku->penulis }}
                            </p>

                            <p class="text-sm mt-2 text-gray-700">
                                Status: {{ ucfirst($item->status) }}
                            </p>
                        </div>

                    </div>
                    @empty
                    <p class="text-gray-500 text-center">Tidak ada buku dipinjam</p>
                    @endforelse
                </div>

                <!-- ================= ANTRIAN ================= -->
                <div class="w-full flex-none py-6 space-y-6 isolate min-h-[420px] overflow-hidden">
                    @forelse($antrian as $item)
                    <div class="bg-white rounded-2xl shadow p-6 flex gap-4">

                        <img src="{{ $item->buku->cover 
                            ? asset('storage/'.$item->buku->cover) 
                            : 'https://via.placeholder.com/150' }}"
                            class="w-24 h-36 rounded shadow object-cover">

                        <div class="flex-1">
                            <p class="font-semibold text-sm">
                                {{ $item->buku->judul }}
                            </p>

                            <p class="text-xs text-gray-500">
                                {{ $item->buku->penulis }}
                            </p>

                            <p class="text-sm mt-2 text-gray-700">
                                Status: Menunggu Antrian
                            </p>
                        </div>

                    </div>
                    @empty
                    <p class="text-gray-500 text-center">Tidak ada antrian</p>
                    @endforelse
                </div>

                <!-- ================= RIWAYAT ================= -->
                <div class="w-full flex-none py-6 space-y-6 isolate min-h-[420px] overflow-hidden">
                    @forelse($riwayat as $item)
                    <div class="bg-white rounded-2xl shadow p-6 flex gap-4">

                        <img src="{{ $item->buku->cover 
                            ? asset('storage/'.$item->buku->cover) 
                            : 'https://via.placeholder.com/150' }}"
                            class="w-24 h-36 rounded shadow object-cover">

                        <div class="flex-1">
                            <p class="font-semibold text-sm">
                                {{ $item->buku->judul }}
                            </p>

                            <p class="text-xs text-gray-500">
                                {{ $item->buku->penulis }}
                            </p>

                            <p class="text-sm mt-2 text-gray-700">
                                Pernah dipinjam
                            </p>
                        </div>

                    </div>
                    @empty
                    <p class="text-gray-500 text-center">Belum ada riwayat</p>
                    @endforelse
                </div>

                <!-- ================= ULASAN ================= -->
                <div class="w-full flex-none py-6 space-y-6 isolate min-h-[420px] overflow-hidden">
                @forelse($ulasan as $item)
                    <div class="bg-white rounded-2xl shadow p-6">
                        <div class="flex gap-4">

                            <!-- AVATAR -->
                            <div class="w-10 h-10 bg-cyan-500 text-white flex items-center justify-center rounded-full text-sm">
                                {{ strtoupper(substr($item->user->nama,0,2)) }}
                            </div>

                            <div class="flex-1">

                                <!-- NAMA -->
                                <p class="font-semibold text-sm">
                                    {{ $item->user->nama }}
                                </p>

                                <!-- TANGGAL -->
                                <p class="text-xs text-gray-500">
                                    Memberikan ulasan • {{ $item->created_at->format('d M Y') }}
                                </p>

                                <!-- KOMENTAR -->
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
                <p class="text-gray-500 text-center">Belum ada ulasan</p>
                @endforelse
                </div>

            </div>
        </div>

    </div>
</section>
@endsection