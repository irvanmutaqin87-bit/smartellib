@extends('layouts.app')

@section('title','Detail Buku - SMARTELLIB')

@section('content')

@if(session('success'))
    <div class="max-w-4xl mx-auto mt-6">
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-3 rounded-2xl shadow-sm">
            {{ session('success') }}
        </div>
    </div>
@endif

    <section class="bg-white py-10 flex justify-center">
    <div class="bg-white w-full max-w-4xl rounded-2xl p-8 shadow-2xl relative">
        <!-- TITIK 3 MENU -->
        <div class="absolute right-6 top-6">

            <!-- BUTTON -->
            <button id="bookMenuButton"
                class="p-2 rounded-full hover:bg-gray-100 transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6 text-gray-500 hover:text-gray-800"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <circle cx="5" cy="12" r="1.5"/>
                    <circle cx="12" cy="12" r="1.5"/>
                    <circle cx="19" cy="12" r="1.5"/>
                </svg>

            </button>

        <!-- DROPDOWN -->
        <div id="bookDropdown"
            class="absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-lg border
            origin-top-right
            opacity-0 scale-y-0 -translate-y-4
            transition-all duration-300 ease-out">

            <!-- BAGIKAN -->
            <button id="openShareModal"
                class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 flex items-center gap-2">

                <!-- ICON -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-cyan-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                </svg>

                Bagikan
            </button>

            <!-- SIMPAN -->
            <button id="saveBookBtn"
                class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 flex items-center gap-2">

                <!-- ICON -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-cyan-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                </svg>

                Simpan Buku
            </button>

            <!-- LAPORKAN -->
            <button id="openReportModal"
                class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 flex items-center gap-2">

                <!-- ICON -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-cyan-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                </svg>

                Laporkan Buku
            </button>

        </div>

        </div>

        <h1 class="text-lg text-cyan-600 mb-6">
        Detail Buku
        </h1>

        <!-- TOP -->
        <div class="flex flex-col md:flex-row gap-8">
        <!-- COVER -->
        <img src="{{ $buku->cover ? asset('storage/' . $buku->cover) : 'https://via.placeholder.com/300x450?text=No+Cover' }}"
            class="w-44 rounded-xl shadow object-cover aspect-[2/3]"
            alt="{{ $buku->judul }}"
        />

        <!-- INFO -->
        <div class="flex-1">
            <h2 class="text-2xl font-semibold">
                {{ $buku->judul }}
            </h2>

            <p class="text-gray-600">
                {{ $buku->penulis }}
            </p>

            <!-- RATING -->
            <div class="flex items-center gap-2 mt-2">
                <div class="flex text-yellow-400 text-lg">
                    @php
                        $avg = round($buku->average_rating);
                    @endphp

                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $avg)
                            ★
                        @else
                            <span class="text-gray-300">★</span>
                        @endif
                    @endfor
                </div>

                <span class="text-gray-600 text-sm">
                    {{ $buku->average_rating }} ({{ $buku->total_rating }} rating)
                </span>
            </div>

            <!-- BUTTON -->
            <div class="flex flex-wrap gap-4 mt-5">

                {{-- PINJAM --}}
                @if($bolehPinjam)
                    <form action="{{ route('anggota.buku.pinjam', $buku->id) }}" method="POST" class="ajax-action-form">
                        @csrf
                        <button type="submit" class="px-6 py-2 bg-cyan-400 text-white rounded-full hover:bg-cyan-500">
                            Pinjam
                        </button>
                    </form>
                @endif

                {{-- ANTRI --}}
                @if($bolehAntri)
                    <form action="{{ route('anggota.antrian.store', $buku->id) }}" method="POST" class="ajax-action-form">
                        @csrf
                        <button type="submit" class="px-6 py-2 bg-yellow-400 text-white rounded-full hover:bg-yellow-500">
                            Masuk Antrian
                        </button>
                    </form>
                @endif

                {{-- BACA --}}
                @if($isDigital && $sedangDipinjamUser)
                    <a href="{{ asset('storage/' . $buku->file_buku) }}" target="_blank"
                        class="px-6 py-2 bg-cyan-400 text-white rounded-full hover:bg-cyan-500">
                        Baca
                    </a>
                @endif

                {{-- DOWNLOAD --}}
                @if($isDigital && $sedangDipinjamUser)
                    <a href="{{ asset('storage/' . $buku->file_buku) }}" download
                        class="px-6 py-2 bg-cyan-400 text-white rounded-full hover:bg-cyan-500">
                        Download
                    </a>
                @endif

                {{-- ULASAN --}}
                @if($bolehUlasan)
                    <button type="button" id="openUlasanModal"
                        class="px-6 py-2 bg-cyan-400 text-white rounded-full hover:bg-cyan-500">
                        {{ $userComment || $userRating ? 'Edit Ulasan' : 'Berikan Ulasan' }}
                    </button>
                @endif
            </div>

            <!-- INFO PINJAM -->
            <p class="text-sm text-gray-500 mt-4">
            Untuk membaca dan download e-book silahkan pinjam buku terlebih dahulu.
            </p>

            <p class="text-sm text-gray-600 mt-2">
                Lama peminjaman:
                <b>{{ $pengaturan->lama_peminjaman ?? 7 }} Hari</b>
            </p>

            <p class="text-sm text-red-400">
                Denda keterlambatan: Rp {{ number_format($dendaPerHari ?? 2000, 0, ',', '.') }} / hari
            </p>

            @if(isset($dendaAktif) && $dendaAktif)
                <div class="mt-5 rounded-2xl border border-red-100 bg-gradient-to-br from-red-50 via-white to-red-50 p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-4 flex-wrap">
                        <div>
                            <p class="text-sm font-semibold text-red-600">
                                Kamu memiliki denda keterlambatan
                            </p>
                            <p class="text-sm text-slate-600 mt-1">
                                Terlambat <b>{{ $dendaAktif->hari_terlambat }}</b> hari
                            </p>
                            <p class="text-sm text-slate-600">
                                Total denda:
                                <b class="text-red-500">Rp {{ number_format($dendaAktif->jumlah_denda, 0, ',', '.') }}</b>
                            </p>
                            <p class="text-xs text-slate-500 mt-1">
                                Status:
                                <span class="font-medium">
                                    {{ str_replace('_', ' ', ucfirst($dendaAktif->status_denda)) }}
                                </span>
                            </p>
                        </div>

                        @if(in_array($dendaAktif->status_denda, ['belum_bayar', 'ditolak']))
                            <button
                                type="button"
                                id="openDendaModal"
                                class="px-5 py-2.5 rounded-full bg-red-500 hover:bg-red-600 text-white text-sm font-medium shadow-md hover:shadow-lg transition-all duration-300">
                                Bayar Denda
                            </button>
                        @elseif($dendaAktif->status_denda === 'menunggu_verifikasi')
                            <span class="px-4 py-2 rounded-full bg-blue-50 text-blue-600 text-sm font-medium border border-blue-100">
                                Menunggu Verifikasi
                            </span>
                        @elseif($dendaAktif->status_denda === 'lunas')
                            <span class="px-4 py-2 rounded-full bg-emerald-50 text-emerald-600 text-sm font-medium border border-emerald-100">
                                Denda Lunas
                            </span>
                        @endif
                    </div>
                </div>
            @endif

        </div>
        </div>

        <!-- FILE INFO -->
        <div class="grid grid-cols-3 mt-8 border rounded-xl p-4 text-center">
        <div>
            <p class="text-gray-500 text-sm">File Size</p>
        <p class="font-semibold">
            @if($buku->file_buku && file_exists(storage_path('app/public/' . $buku->file_buku)))
                {{ round(filesize(storage_path('app/public/' . $buku->file_buku)) / 1024 / 1024, 2) }} MB
            @else
                -
            @endif
        </p>
        </div>

        <div>
            <p class="text-gray-500 text-sm">Total Copy</p>
            <p class="font-semibold">{{ $buku->stok ?? 0 }}</p>
        </div>

        <div>
            <p class="text-gray-500 text-sm">Tersedia Copy</p>
            <p class="font-semibold">{{ max(($buku->stok ?? 0) - $sedangDipinjam, 0) }}</p>
        </div>
        </div>

        <!-- STATISTIK -->
        <div class="flex justify-center gap-20 text-center mt-10 flex-wrap">
            <div>
                <p class="font-semibold">Telah Dipinjam</p>
                <p class="text-gray-500">{{ $totalDipinjam }} Pengguna</p>
            </div>

            <div>
                <p class="font-semibold">Antrian</p>
                <p class="text-gray-500">{{ $totalAntrian }} Pengguna</p>
            </div>

            <div>
                <p class="font-semibold">Sedang Dipinjam</p>
                <p class="text-gray-500">{{ $sedangDipinjam }} Pengguna</p>
            </div>
        </div>

        <hr class="my-8" />
        <!-- TABS -->
        <div class="mt-10">
        <!-- NAV TAB -->
        <div class="relative flex justify-center gap-12 border-b pb-3">

            <button
            onclick="switchTab(0)"
            class="tab-link text-gray-500 font-medium hover:text-cyan-600 transition"
            >
            Deskripsi
            </button>

            <button
            onclick="switchTab(1)"
            class="tab-link text-gray-500 font-medium hover:text-cyan-600 transition"
            >
            Detail
            </button>

            <button
            onclick="switchTab(2)"
            class="tab-link text-gray-500 font-medium hover:text-cyan-600 transition"
            >
            Ulasan
            </button>

            <!-- SLIDER -->
            <span
            id="tabIndicator"
            class="absolute bottom-0 h-[2px] bg-cyan-500 rounded transition-all duration-300"
            ></span>

        </div>

        <!-- CONTENT -->
        <div class="overflow-hidden mt-8">
            <div
            id="tabContent"
            class="flex transition-transform duration-500"
            >

            <!-- DESKRIPSI -->
            <div class="min-w-full px-6">

            <p
                id="descText"
                class="text-gray-700 leading-relaxed line-clamp-2 transition-all duration-500 overflow-hidden"
            >
                {{ $buku->deskripsi ?? 'Belum ada deskripsi buku.' }}
            </p>

            <button
                onclick="toggleDesc()"
                id="descBtn"
                class="text-cyan-600 text-sm font-medium mt-2 hover:underline"
            >
            Selengkapnya
            </button>

            </div>

            <!-- DETAIL -->
            <div class="min-w-full px-6">

                <div class="grid grid-cols-2 gap-y-4 gap-x-10 text-sm">
                    <div>
                        <p class="text-gray-500">Pengarang</p>
                        <p class="font-semibold">{{ $buku->penulis }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Penerbit</p>
                        <p class="font-semibold">{{ $buku->penerbit ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Tahun Terbit</p>
                        <p class="font-semibold">{{ $buku->tahun_terbit ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Kategori</p>
                        <p class="font-semibold">{{ $buku->kategori->nama_kategori ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Total Halaman</p>
                        <p class="font-semibold">{{ $buku->total_halaman ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Kode Buku</p>
                        <p class="font-semibold">{{ $buku->kode_buku ?? '-' }}</p>
                    </div>
                </div>
            </div>

                <div class="min-w-full px-6 space-y-6">

                    @forelse($ulasan as $komen)
                        @php
                            $ratingUser = $ratingsByUser[$komen->user_id]->rating ?? 0;
                        @endphp

                        <div class="flex gap-4 p-4 rounded-2xl border border-slate-100 bg-slate-50">
                            <div class="w-11 h-11 bg-cyan-100 text-cyan-700 rounded-full flex items-center justify-center font-semibold">
                                {{ strtoupper(substr($komen->user->name ?? 'U', 0, 1)) }}
                            </div>

                            <div class="flex-1">
                                <div class="flex items-center justify-between flex-wrap gap-2">
                                    <div>
                                        <p class="font-semibold text-sm text-slate-800">
                                            {{ $komen->user->name ?? 'Pengguna' }}
                                        </p>

                                        <div class="text-yellow-400 text-sm mt-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $ratingUser)
                                                    ★
                                                @else
                                                    <span class="text-gray-300">★</span>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>

                                    <p class="text-xs text-slate-400">
                                        {{ $komen->created_at?->diffForHumans() }}
                                    </p>
                                </div>

                                <p class="text-gray-600 text-sm mt-2 leading-relaxed">
                                    {{ $komen->comment }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 text-gray-500">
                            Belum ada ulasan untuk buku ini.
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
        </div>
    </div>
    </section>

<section class="max-w-7xl mx-auto px-24 py-16">

    <div class="flex items-center justify-between mb-10">
        <h2 class="text-lg font-medium text-gray-700 tracking-wide">
            Buku Serupa
        </h2>
    </div>

    <!-- GRID BUKU -->
    <div
        id="bookContainer"
        class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-10"
    >
        @forelse($bukuSerupa as $item)
            <a href="{{ route('anggota.buku.detail', $item->id) }}"
                class="book-card group block cursor-pointer opacity-0 translate-y-6 transition-all duration-500 transform-gpu active:scale-95">

                <div
                    class="relative overflow-hidden rounded-xl shadow-[0_6px_18px_rgba(0,0,0,0.08)] transition-all duration-500 group-hover:-translate-y-3 group-hover:shadow-[0_20px_45px_rgba(0,0,0,0.20)]">

                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/10 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition">
                    </div>

                    <img
                        src="{{ $item->cover ? asset('storage/' . $item->cover) : 'https://via.placeholder.com/300x450?text=No+Cover' }}"
                        alt="{{ $item->judul }}"
                        class="w-full aspect-[2/3] object-cover brightness-110 contrast-110 transition duration-500 group-hover:scale-105"
                    />
                </div>

                <h3 class="mt-3 text-sm font-semibold text-gray-800 line-clamp-2">
                    {{ $item->judul }}
                </h3>

                <p class="text-xs text-gray-500">
                    {{ $item->penulis }}
                </p>
            </a>
        @empty
            <div class="col-span-full text-center py-10 text-gray-500">
                Belum ada buku serupa.
            </div>
        @endforelse
    </div>

    @if($bukuSerupa->count() >= 5)
    <div class="flex justify-center mt-14">
        <button
            id="loadMoreBtn"
            onclick="loadMoreBooks()"
            class="flex items-center gap-2 hover:gap-3 px-10 py-3 text-sm rounded-full bg-cyan-500 hover:bg-cyan-600 text-white shadow-md transition duration-300">

            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-4 h-4">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
            </svg>

            Selengkapnya
        </button>
    </div>
    @endif

</section>

<!-- MODAL BAGIKAN BUKU -->
<div id="shareModal"
class="fixed inset-0 z-50 flex items-center justify-center
bg-black/40 backdrop-blur-sm
opacity-0 pointer-events-none transition duration-300">

    <div id="shareCard"
    class="bg-white w-[420px] rounded-2xl shadow-xl p-7
    opacity-0 scale-90 translate-y-6
    transition-all duration-300">

        <!-- HEADER -->
        <h3 class="text-lg font-semibold text-gray-800 mb-1 text-center">
            Bagikan ke...
        </h3>

        <p class="text-sm text-gray-500 mb-6">
            Kirim buku ini ke teman kamu melalui media sosial.
        </p>

        <!-- LIST SHARE -->
        <div class="space-y-2">

            <!-- COPY LINK -->
            <button id="copyBookLink"
            class="w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-50 transition group">

                <!-- ICON LINK -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-cyan-500 transition group-hover:scale-110">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                </svg>

                Salin Link
            </button>

            <!-- WHATSAPP -->
            <a id="shareWA" target="_blank"
            class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-50 transition group">

                <svg class="w-6 h-6 transition group-hover:scale-110" viewBox="0 0 24 24">
                    <path fill="#25D366" d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>

                WhatsApp
            </a>

            <!-- FACEBOOK -->
            <a id="shareFB" target="_blank"
            class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-50 transition group">

                <svg class="w-6 h-6 transition group-hover:scale-110" viewBox="0 0 24 24">
                    <path fill="#1877F2" d="M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978.401 0 .955.042 1.468.103a8.68 8.68 0 0 1 1.141.195v3.325a8.623 8.623 0 0 0-.653-.036 26.805 26.805 0 0 0-.733-.009c-.707 0-1.259.096-1.675.309a1.686 1.686 0 0 0-.679.622c-.258.42-.374.995-.374 1.752v1.297h3.919l-.386 2.103-.287 1.564h-3.246v8.245C19.396 23.238 24 18.179 24 12.044c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.628 3.874 10.35 9.101 11.647Z"/>
                </svg>

                Facebook
            </a>

            <!-- TELEGRAM -->
            <a id="shareTG" target="_blank"
            class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-50 transition group">

                <svg class="w-6 h-6 transition group-hover:scale-110" viewBox="0 0 24 24">
                    <path fill="#229ED9" d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                </svg>

                Telegram
            </a>

            <!-- TWITTER X -->
            <a id="shareTW" target="_blank"
            class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-50 transition group">

                <svg class="w-5 h-5 transition group-hover:scale-110" viewBox="0 0 24 24">
                    <path fill="#000000" d="M14.234 10.162 22.977 0h-2.072l-7.591 8.824L7.251 0H.258l9.168 13.343L.258 24H2.33l8.016-9.318L16.749 24h6.993zm-2.837 3.299-.929-1.329L3.076 1.56h3.182l5.965 8.532.929 1.329 7.754 11.09h-3.182z"/>
                </svg>

                Twitter / X
            </a>

        </div>

        <!-- FOOTER BUTTON -->
        <div class="flex justify-end mt-6">

            <button id="closeShareModal"
            class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-cyan-500">
                Batal
            </button>

        </div>

    </div>

</div>

<!-- MODAL BAYAR DENDA BUKU -->
@if(isset($dendaAktif) && $dendaAktif && in_array($dendaAktif->status_denda, ['belum_bayar', 'ditolak']))
<div id="reportModal"
class="fixed inset-0 z-[60] flex items-center justify-center
bg-black/40 backdrop-blur-sm
opacity-0 pointer-events-none transition duration-300">

    <div id="reportCard"
    class="bg-white w-[92%] max-w-md rounded-[28px] shadow-2xl p-7
    opacity-0 scale-75 translate-y-8
    transition-all duration-300 ease-out">

        <div class="text-center mb-6">
            <div class="w-16 h-16 mx-auto rounded-full bg-red-50 flex items-center justify-center mb-4 shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 1.343-3 3v2a3 3 0 006 0v-2c0-1.657-1.343-3-3-3z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v2m0 14v2m8-8h-2M6 12H4"/>
                </svg>
            </div>

            <h3 class="text-xl font-semibold text-slate-800">
                Bayar Denda
            </h3>

            <p class="text-sm text-slate-500 mt-1">
                Upload bukti pembayaran untuk proses verifikasi petugas.
            </p>
        </div>

        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4 mb-5">
            <div class="flex justify-between text-sm text-slate-600 mb-2">
                <span>Hari Terlambat</span>
                <span class="font-medium">{{ $dendaAktif->hari_terlambat }} Hari</span>
            </div>
            <div class="flex justify-between text-sm text-slate-600">
                <span>Total Denda</span>
                <span class="font-semibold text-red-500">Rp {{ number_format($dendaAktif->jumlah_denda, 0, ',', '.') }}</span>
            </div>
        </div>

        <form action="{{ route('anggota.denda.uploadBukti', $dendaAktif->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Upload Bukti Pembayaran
                </label>
                <input type="file"
                    name="bukti_pembayaran"
                    accept="image/*"
                    required
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-200">
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Catatan (Opsional)
                </label>
                <textarea
                    name="catatan_verifikasi"
                    rows="3"
                    placeholder="Contoh: transfer via bank / e-wallet"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-200 resize-none"></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button"
                    id="closeDendaModal"
                    class="px-5 py-2.5 rounded-full text-sm font-medium text-slate-500 hover:text-red-500 transition">
                    Batal
                </button>

                <button type="submit"
                    class="px-6 py-2.5 rounded-full bg-red-500 hover:bg-red-600 text-white text-sm font-medium shadow-md hover:shadow-lg transition-all duration-300">
                    Upload Bukti
                </button>
            </div>
        </form>
    </div>
</div>

@endif
<!-- MODAL ULASAN -->
<div id="reviewModal"
class="fixed inset-0 z-[70] flex items-center justify-center
bg-black/40 backdrop-blur-sm
opacity-0 pointer-events-none transition duration-300">

    <div id="reviewCard"
    class="bg-white w-[92%] max-w-lg rounded-[28px] shadow-2xl p-7
    opacity-0 scale-75 translate-y-8
    transition-all duration-300 ease-out">

        <div class="text-center mb-6">
            <h3 class="text-xl font-semibold text-slate-800">
                {{ $userRating || $userComment ? 'Edit Ulasan' : 'Berikan Ulasan' }}
            </h3>
            <p class="text-sm text-slate-500 mt-1">
                Berikan penilaian dan komentar untuk buku ini.
            </p>
        </div>

        <form action="{{ route('anggota.buku.ulasan.store', $buku->id) }}" method="POST">
            @csrf

            <!-- RATING -->
            <div class="mb-5 text-center">
                <label class="block text-sm font-medium text-slate-700 mb-3">
                    Rating Buku
                </label>

                <div class="flex justify-center gap-2 text-3xl">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button"
                            class="star-btn text-gray-300 hover:scale-110 transition"
                            data-value="{{ $i }}">
                            ★
                        </button>
                    @endfor
                </div>

                <input type="hidden" name="rating" id="ratingInput"
                    value="{{ old('rating', $userRating->rating ?? 0) }}">
            </div>

            <!-- KOMENTAR -->
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Ulasan Kamu
                </label>
                <textarea
                    name="comment"
                    rows="5"
                    required
                    placeholder="Tulis pengalaman atau pendapat kamu tentang buku ini..."
                    class="w-full border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-200 resize-none">{{ old('comment', $userComment->comment ?? '') }}</textarea>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button"
                    id="closeReviewModal"
                    class="px-5 py-2.5 rounded-full text-sm font-medium text-slate-500 hover:text-cyan-500 transition">
                    Batal
                </button>

                <button type="submit"
                    class="px-6 py-2.5 rounded-full bg-cyan-500 hover:bg-cyan-600 text-white text-sm font-medium shadow-md hover:shadow-lg transition-all duration-300">
                    Simpan Ulasan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
<script>
    // =========================
    // TAB SWITCH
    // =========================
    let currentTab = 0;
    const tabContent = document.getElementById("tabContent");
    const tabLinks = document.querySelectorAll(".tab-link");
    const tabIndicator = document.getElementById("tabIndicator");

    function switchTab(index) {
        currentTab = index;
        tabContent.style.transform = `translateX(-${index * 100}%)`;

        tabLinks.forEach((tab, i) => {
            tab.classList.toggle("text-cyan-600", i === index);
            tab.classList.toggle("text-gray-500", i !== index);
        });

        moveIndicator();
    }

    function moveIndicator() {
        const activeTab = tabLinks[currentTab];
        tabIndicator.style.width = `${activeTab.offsetWidth}px`;
        tabIndicator.style.left = `${activeTab.offsetLeft}px`;
    }

    window.addEventListener("load", () => {
        switchTab(0);
    });

    window.addEventListener("resize", moveIndicator);

    // =========================
    // DESKRIPSI TOGGLE
    // =========================
    function toggleDesc() {
        const desc = document.getElementById("descText");
        const btn = document.getElementById("descBtn");

        desc.classList.toggle("line-clamp-2");

        if (desc.classList.contains("line-clamp-2")) {
            btn.innerText = "Selengkapnya";
        } else {
            btn.innerText = "Sembunyikan";
        }
    }

    // =========================
    // MODAL ULASAN
    // =========================
    const reviewModal = document.getElementById("reviewModal");
    const reviewCard = document.getElementById("reviewCard");
    const closeReviewModalBtn = document.getElementById("closeReviewModal");

    function openReviewModal() {
        reviewModal.classList.remove("opacity-0", "pointer-events-none");
        reviewCard.classList.remove("opacity-0", "scale-75", "translate-y-8");
        reviewCard.classList.add("opacity-100", "scale-100", "translate-y-0");
    }

    function closeReviewModal() {
        reviewModal.classList.add("opacity-0", "pointer-events-none");
        reviewCard.classList.add("opacity-0", "scale-75", "translate-y-8");
        reviewCard.classList.remove("opacity-100", "scale-100", "translate-y-0");
    }

    closeReviewModalBtn?.addEventListener("click", closeReviewModal);
    reviewModal?.addEventListener("click", (e) => {
        if (e.target === reviewModal) closeReviewModal();
    });

    // =========================
    // STAR RATING
    // =========================
    const starButtons = document.querySelectorAll(".star-btn");
    const ratingInput = document.getElementById("ratingInput");

    function renderStars(value) {
        starButtons.forEach((star, index) => {
            if (index < value) {
                star.classList.remove("text-gray-300");
                star.classList.add("text-yellow-400");
            } else {
                star.classList.remove("text-yellow-400");
                star.classList.add("text-gray-300");
            }
        });
    }

    starButtons.forEach((star) => {
        star.addEventListener("click", function () {
            const value = parseInt(this.dataset.value);
            ratingInput.value = value;
            renderStars(value);
        });
    });

    renderStars(parseInt(ratingInput?.value || 0));
</script>