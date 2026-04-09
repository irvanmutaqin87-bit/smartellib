@extends('layouts.dashboard_admin')

@section('title', 'Manajemen Laporan - SMARTELLIB')

@section('header')
<span class="text-2xl font-semibold">Manajemen Laporan</span>
@endsection

@section('content')
<div class="relative">

    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 mb-5">
        <span class="px-4 py-2 text-white text-sm font-semibold rounded-lg shadow-sm bg-cyan-900/80">
            Data Laporan
        </span>
    </div>

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-5">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">Laporan Perpustakaan</h1>
            <p class="text-sm text-slate-500 mt-1">
                Kelola laporan peminjaman, pengembalian, dan denda secara rapi.
            </p>
        </div>

        <a id="downloadPdfBtn"
            href="{{ route('admin.laporan.downloadPdf') }}?jenis_laporan=peminjaman"
            class="inline-flex items-center gap-2 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow bg-rose-500 hover:bg-rose-600 transition-colors">
            Download PDF
        </a>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-5">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <p class="text-sm text-slate-500">Total Peminjaman</p>
            <h2 class="text-2xl font-bold text-slate-800 mt-2">{{ $totalPeminjaman }}</h2>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <p class="text-sm text-slate-500">Total Pengembalian</p>
            <h2 class="text-2xl font-bold text-slate-800 mt-2">{{ $totalPengembalian }}</h2>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <p class="text-sm text-slate-500">Total Denda</p>
            <h2 class="text-2xl font-bold text-slate-800 mt-2">{{ $totalDenda }}</h2>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <p class="text-sm text-slate-500">Pendapatan Denda</p>
            <h2 class="text-2xl font-bold text-slate-800 mt-2">
                Rp {{ number_format($totalPendapatanDenda, 0, ',', '.') }}
            </h2>
        </div>
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap items-center gap-3 mb-5">

        <!-- Search -->
        <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-4 py-2.5 flex-1 min-w-[220px] max-w-sm shadow-sm">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8" stroke="#94a3b8" stroke-width="2"/>
                <path d="M21 21l-4.35-4.35" stroke="#94a3b8" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <input 
                type="text" 
                id="searchInput"
                placeholder="Cari nama / judul..." 
                class="bg-transparent text-sm outline-none text-slate-700 placeholder-slate-400 w-full"
            />
        </div>

        <!-- ================= FILTER JENIS LAPORAN ================= -->
        <div class="relative">
            <button id="jenisLaporanBtn"
                type="button"
                class="w-[220px] bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 shadow-sm cursor-pointer hover:border-cyan-700 transition-colors flex items-center justify-between">
                <span id="jenisLaporanText">Laporan Peminjaman</span>
                <svg id="jenisLaporanIcon"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 transition-all duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <input type="hidden" id="jenisLaporanFilter" name="jenis_laporan" value="peminjaman">

            <div id="jenisLaporanDropdown"
                class="absolute left-0 mt-3 w-full bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border p-2 z-50
                origin-top scale-y-95 opacity-0 -translate-y-2 pointer-events-none
                transition-all duration-300 ease-out">

                <button type="button" class="jenisLaporanOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="peminjaman">
                    Laporan Peminjaman
                </button>
                <button type="button" class="jenisLaporanOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="pengembalian">
                    Laporan Pengembalian
                </button>
                <button type="button" class="jenisLaporanOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="denda">
                    Laporan Denda
                </button>
            </div>
        </div>

        <!-- ================= FILTER PERIODE ================= -->
        <div class="relative">
            <button id="periodeFilterBtn"
                type="button"
                class="w-[190px] bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 shadow-sm cursor-pointer hover:border-cyan-700 transition-colors flex items-center justify-between">
                <span id="periodeFilterText">Semua Periode</span>
                <svg id="periodeFilterIcon"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 transition-all duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <input type="hidden" id="periodeFilter" name="periode" value="">

            <div id="periodeFilterDropdown"
                class="absolute left-0 mt-3 w-full bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border p-2 z-50
                origin-top scale-y-95 opacity-0 -translate-y-2 pointer-events-none
                transition-all duration-300 ease-out">

                <button type="button" class="periodeOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="">
                    Semua Periode
                </button>
                <button type="button" class="periodeOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="hari_ini">
                    Hari Ini
                </button>
                <button type="button" class="periodeOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="7_hari">
                    7 Hari Terakhir
                </button>
                <button type="button" class="periodeOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="bulan_ini">
                    Bulan Ini
                </button>
                <button type="button" class="periodeOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="tahun_ini">
                    Tahun Ini
                </button>
            </div>
        </div>

        <!-- ================= FILTER STATUS ================= -->
        <div class="relative">
            <button id="statusFilterBtn"
                type="button"
                class="w-[190px] bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 shadow-sm cursor-pointer hover:border-cyan-700 transition-colors flex items-center justify-between">
                <span id="statusFilterText">Semua Status</span>
                <svg id="statusFilterIcon"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 transition-all duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <input type="hidden" id="statusFilter" name="status" value="">

            <div id="statusFilterDropdown"
                class="absolute left-0 mt-3 w-full bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border p-2 z-50
                origin-top scale-y-95 opacity-0 -translate-y-2 pointer-events-none
                transition-all duration-300 ease-out">

                <div id="statusOptionsWrapper">
                    <button type="button" class="statusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="">
                        Semua Status
                    </button>
                    <button type="button" class="statusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="dipinjam">
                        Dipinjam
                    </button>
                    <button type="button" class="statusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="dikembalikan">
                        Dikembalikan
                    </button>
                    <button type="button" class="statusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="terlambat">
                        Terlambat
                    </button>
                </div>
            </div>
        </div>

        <!-- Tanggal Dari -->
        <div>
            <input type="date" id="tanggalDariFilter"
                class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-200">
        </div>

        <!-- Tanggal Sampai -->
        <div>
            <input type="date" id="tanggalSampaiFilter"
                class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-200">
        </div>

        <!-- ================= FILTER BULAN ================= -->
        <div class="relative">
            <button id="bulanFilterBtn"
                type="button"
                class="w-[180px] bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 shadow-sm cursor-pointer hover:border-cyan-700 transition-colors flex items-center justify-between">
                <span id="bulanFilterText">Semua Bulan</span>
                <svg id="bulanFilterIcon"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 transition-all duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <input type="hidden" id="bulanFilter" name="bulan" value="">

            <div id="bulanFilterDropdown"
                class="absolute left-0 mt-3 w-full bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border p-2 z-50 max-h-72 overflow-y-auto
                origin-top scale-y-95 opacity-0 -translate-y-2 pointer-events-none
                transition-all duration-300 ease-out">

                <button type="button" class="bulanOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="">
                    Semua Bulan
                </button>

                @for($i = 1; $i <= 12; $i++)
                    <button type="button" class="bulanOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="{{ $i }}">
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                    </button>
                @endfor
            </div>
        </div>

        <!-- ================= FILTER TAHUN ================= -->
        <div class="relative">
            <button id="tahunFilterBtn"
                type="button"
                class="w-[160px] bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 shadow-sm cursor-pointer hover:border-cyan-700 transition-colors flex items-center justify-between">
                <span id="tahunFilterText">Semua Tahun</span>
                <svg id="tahunFilterIcon"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 transition-all duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <input type="hidden" id="tahunFilter" name="tahun" value="">

            <div id="tahunFilterDropdown"
                class="absolute left-0 mt-3 w-full bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border p-2 z-50 max-h-72 overflow-y-auto
                origin-top scale-y-95 opacity-0 -translate-y-2 pointer-events-none
                transition-all duration-300 ease-out">

                <button type="button" class="tahunOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="">
                    Semua Tahun
                </button>

                @for($year = now()->year; $year >= now()->year - 5; $year--)
                    <button type="button" class="tahunOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="{{ $year }}">
                        {{ $year }}
                    </button>
                @endfor
            </div>
        </div>

        <!-- Total -->
        <div id="totalLaporanBox"
            class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 shadow-sm">
            Total Data : 0
        </div>

        <!-- Reset -->
        <button type="button" id="resetLaporanFilter"
            class="ml-auto px-5 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">
            Reset Filter
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-visible relative">
        <div id="tableContainer">
            <div class="px-5 py-10 text-center text-slate-400 text-sm">
                Memuat data laporan...
            </div>
        </div>

        <div id="paginationContainer">
            {{-- AJAX Pagination --}}
        </div>
    </div>

</div>

{{-- MODAL DETAIL --}}
<div id="laporanDetailModal"
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm px-4">
    <div class="w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden animate-[fadeIn_.25s_ease]">
        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-200">
            <div>
                <h3 class="text-lg font-semibold text-slate-800">Detail Laporan</h3>
                <p class="text-sm text-slate-500">Informasi lengkap data laporan</p>
            </div>
            <button type="button" id="closeLaporanDetailModal"
                class="w-10 h-10 rounded-xl hover:bg-slate-100 flex items-center justify-center transition">
                ✕
            </button>
        </div>

        <div id="laporanDetailContent" class="p-6">
            {{-- inject detail --}}
        </div>
    </div>
</div>
@endsection