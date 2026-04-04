@extends('layouts.dashboard_petugas')

@section('title', 'Detail Buku Petugas - SMARTELLIB')

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
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" stroke="#cbd5e1" stroke-width="1.5"/>
                </svg>
            </div>

            <!-- Informasi Buku -->
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold text-slate-800 mb-1 truncate">
                    Atomic Habits
                </h2>

                <p class="text-slate-400 text-sm mb-6 truncate">
                    James Clear
                </p>

                <div class="grid grid-cols-1 gap-y-4">

                    <div class="flex gap-3 min-w-0">
                        <span class="text-slate-400 text-sm w-32 shrink-0">Kode Buku</span>
                        <span class="text-sm font-semibold text-slate-700 truncate">: BK001</span>
                    </div>

                    <div class="flex gap-3 min-w-0">
                        <span class="text-slate-400 text-sm w-32 shrink-0">Total Halaman</span>
                        <span class="text-sm font-semibold text-slate-700 truncate">: 312 Halaman</span>
                    </div>

                    <div class="flex gap-3 min-w-0">
                        <span class="text-slate-400 text-sm w-32 shrink-0">Penulis</span>
                        <span class="text-sm font-semibold text-slate-700 truncate">: James Clear</span>
                    </div>

                    <div class="flex gap-3 min-w-0">
                        <span class="text-slate-400 text-sm w-32 shrink-0">Kategori</span>
                        <span class="text-sm font-semibold text-slate-700 truncate">: Self Development</span>
                    </div>

                    <div class="flex gap-3 min-w-0">
                        <span class="text-slate-400 text-sm w-32 shrink-0">Penerbit</span>
                        <span class="text-sm font-semibold text-slate-700 truncate">: Gramedia Pustaka Utama</span>
                    </div>

                    <div class="flex gap-3 min-w-0">
                        <span class="text-slate-400 text-sm w-32 shrink-0">Tahun Terbit</span>
                        <span class="text-sm font-semibold text-slate-700 truncate">: 2019</span>
                    </div>

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
                        <span class="font-semibold text-slate-700">12</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-400">Sedang Dipinjam</span>
                        <span class="font-semibold text-slate-700">2</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-400">Tersedia</span>
                        <span class="font-semibold text-slate-700">10</span>
                    </div>

                    <div class="flex justify-between items-center pt-2 border-t">
                        <span class="text-slate-400">Status</span>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">
                            Tersedia
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
            Atomic Habits karya James Clear membahas bagaimana perubahan kecil yang dilakukan secara konsisten
            dapat memberikan hasil besar dalam jangka panjang. Buku ini menjelaskan konsep pembentukan kebiasaan
            melalui langkah-langkah sederhana, mulai dari mengenali pemicu kebiasaan, membangun rutinitas positif,
            hingga menghilangkan kebiasaan buruk.
        </p>
    </div>

    <!-- ================= Tombol ================= -->
    <div class="flex flex-wrap items-center gap-3 mt-8 pt-6 border-t border-slate-100">
        
        <a href="{{ route('petugas.manajemen_buku') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-colors">
            Kembali
        </a>

        <div class="flex-1"></div>

        <!-- Gradient Edit -->
        <a href="{{ route('petugas.edit_buku') }}"
        class="px-6 py-2.5 text-white text-sm font-semibold rounded-xl shadow-sm
        bg-gradient-to-r from-cyan-700 to-cyan-900
        hover:from-cyan-800 hover:to-cyan-950 transition">
            Edit Buku
        </a>

        <!-- Gradient Hapus -->
        <button onclick="confirmDelete()"
        class="px-6 py-2.5 text-white text-sm font-semibold rounded-xl shadow-sm
        bg-gradient-to-r from-rose-500 to-red-600
        hover:from-rose-600 hover:to-red-700 transition">
            Hapus Buku
        </button>

    </div>

</div>

@endsection