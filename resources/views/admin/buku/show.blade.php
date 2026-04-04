@extends('layouts.dashboard_admin')

@section('title', 'Detail Buku - SMARTELLIB')

@section('header')
<span class="text-2xl font-semibold">Detail Buku</span>
@endsection

@section('content')

<div class="flex items-center gap-2 mb-5">
    <span class="px-4 py-2 text-white text-sm font-semibold rounded-lg shadow-sm bg-cyan-900/80">
        Detail Buku
    </span>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
    
    <div class="flex flex-col lg:flex-row gap-8">

        <!-- ================= KIRI (Cover + Info Buku) ================= -->
        <div class="flex flex-col sm:flex-row gap-6 flex-1">

            <!-- Cover Buku -->
            <div class="w-full sm:w-52 h-72 bg-slate-100 rounded-xl border border-slate-200 flex items-center justify-center shrink-0 overflow-hidden">
                @if($buku->cover)
                    <img 
                        src="{{ asset('storage/' . $buku->cover) }}" 
                        alt="{{ $buku->judul }}"
                        class="w-full h-full object-cover"
                    >
                @else
                    <div class="flex items-center justify-center w-full h-full">
                        <svg width="48" height="48" fill="none" viewBox="0 0 24 24">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" stroke="#cbd5e1" stroke-width="1.5"/>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Informasi Buku -->
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold text-slate-800 mb-1 truncate">
                    {{ $buku->judul }}
                </h2>

                <p class="text-slate-400 text-sm mb-6 truncate">
                    {{ $buku->penulis }}
                </p>

                <div class="grid grid-cols-1 gap-y-4">

                    <div class="flex gap-3 min-w-0">
                        <span class="text-slate-400 text-sm w-32 shrink-0">Kode Buku</span>
                        <span class="text-sm font-semibold text-slate-700 truncate">: {{ $buku->kode_buku }}</span>
                    </div>

                    <div class="flex gap-3 min-w-0">
                        <span class="text-slate-400 text-sm w-32 shrink-0">Total Halaman</span>
                        <span class="text-sm font-semibold text-slate-700 truncate">: {{ $buku->total_halaman }} Halaman</span>
                    </div>

                    <div class="flex gap-3 min-w-0">
                        <span class="text-slate-400 text-sm w-32 shrink-0">Penulis</span>
                        <span class="text-sm font-semibold text-slate-700 truncate">: {{ $buku->penulis }}</span>
                    </div>

                    <div class="flex gap-3 min-w-0">
                        <span class="text-slate-400 text-sm w-32 shrink-0">Kategori</span>
                        <span class="text-sm font-semibold text-slate-700 truncate">: {{ $buku->kategori->nama_kategori ?? '-' }}</span>
                    </div>

                    <div class="flex gap-3 min-w-0">
                        <span class="text-slate-400 text-sm w-32 shrink-0">Penerbit</span>
                        <span class="text-sm font-semibold text-slate-700 truncate">: {{ $buku->penerbit }}</span>
                    </div>

                    <div class="flex gap-3 min-w-0">
                        <span class="text-slate-400 text-sm w-32 shrink-0">Tahun Terbit</span>
                        <span class="text-sm font-semibold text-slate-700 truncate">: {{ $buku->tahun_terbit }}</span>
                    </div>

                    @if($buku->file_buku)
                    <div class="flex gap-3 min-w-0">
                        <span class="text-slate-400 text-sm w-32 shrink-0">File PDF</span>
                        <span class="text-sm font-semibold text-slate-700 truncate">
                            :
                            <a href="{{ asset('storage/' . $buku->file_buku) }}"
                               target="_blank"
                               class="text-cyan-700 hover:text-cyan-900 underline underline-offset-2">
                                Lihat File Buku
                            </a>
                        </span>
                    </div>
                    @endif

                </div>
            </div>
        </div>

        <!-- ================= KANAN (Informasi Stok) ================= -->
        <div class="w-full lg:w-72 shrink-0">
            <div class="bg-slate-50 rounded-xl border border-slate-200 overflow-hidden shadow-sm">
                
                <div class="bg-slate-200 px-4 py-2">
                    <p class="text-sm font-semibold text-slate-700">Informasi Stok</p>
                </div>

                <div class="p-4 space-y-3 text-sm">
                    
                    <div class="flex justify-between">
                        <span class="text-slate-400">Stok Total</span>
                        <span class="font-semibold text-slate-700">{{ $stokTotal }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-400">Sedang Dipinjam</span>
                        <span class="font-semibold text-slate-700">{{ $sedangDipinjam }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-400">Tersedia</span>
                        <span class="font-semibold text-slate-700">{{ $tersedia }}</span>
                    </div>

                    <div class="flex justify-between items-center pt-2 border-t">
                        <span class="text-slate-400">Status</span>

                        <span id="statusBadge">
                            @if($tersedia > 0)
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">
                                    Tersedia
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-rose-100 text-rose-700">
                                    Habis
                                </span>
                            @endif
                        </span>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- ================= Deskripsi ================= -->
    <div class="mt-8 pt-6 border-t border-slate-100">
        <p class="font-bold text-slate-700 mb-2 text-sm">Deskripsi Buku</p>
        <p class="text-slate-500 text-sm leading-relaxed">
            {{ $buku->deskripsi ?: 'Tidak ada deskripsi buku.' }}
        </p>
    </div>

    <!-- ================= Tombol ================= -->
    <div class="flex flex-wrap items-center gap-3 mt-8 pt-6 border-t border-slate-100">
        
        <a href="{{ route('admin.buku.index') }}" 
           class="px-6 py-2.5 bg-cyan-900 hover:bg-cyan-800 text-white text-sm font-semibold rounded-xl transition-colors">
            Kembali
        </a>

    </div>

</div>

@endsection