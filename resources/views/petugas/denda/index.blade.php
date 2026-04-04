@extends('layouts.dashboard_petugas')

@section('title', 'Manajemen Denda Petugas - SMARTELLIB')

@section('header')
<span class="text-2xl font-semibold">Manajemen Denda</span>
@endsection

@section('content')

<div class="relative">

    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 mb-5">
        <span class="px-4 py-2 text-white text-sm font-semibold rounded-lg shadow-sm bg-cyan-900/80">
            Daftar Denda
        </span>
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap items-center gap-3 mb-5">

        <!-- Search -->
        <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-4 py-2.5 flex-1 min-w-[240px] max-w-sm shadow-sm">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8" stroke="#94a3b8" stroke-width="2"/>
                <path d="M21 21l-4.35-4.35" stroke="#94a3b8" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <input 
                type="text" 
                id="searchInput"
                placeholder="Cari anggota / judul..." 
                class="bg-transparent text-sm outline-none text-slate-700 placeholder-slate-400 w-full"
            />
        </div>

        <!-- FILTER STATUS -->
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

            <input type="hidden" id="statusFilter" name="statusFilter" value="">

            <div id="statusFilterDropdown"
                class="absolute left-0 mt-3 w-full bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border p-2 z-50
                origin-top scale-y-95 opacity-0 -translate-y-2 pointer-events-none
                transition-all duration-300 ease-out">

                <button type="button" class="statusOption w-full text-left px-2 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="">
                    Semua Status
                </button>
                <button type="button" class="statusOption w-full text-left px-2 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="belum_bayar">
                    Belum Bayar
                </button>
                <button type="button" class="statusOption w-full text-left px-2 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="menunggu_verifikasi">
                    Menunggu Verifikasi
                </button>
                <button type="button" class="statusOption w-full text-left px-2 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="lunas">
                    Lunas
                </button>
                <button type="button" class="statusOption w-full text-left px-2 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="ditolak">
                    Ditolak
                </button>
            </div>
        </div>

        <!-- Total -->
        <div id="totalDendaBox"
            class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 shadow-sm">
            Total Denda : {{ $data->total() }}
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-visible relative">

        <!-- TOAST -->
        <div id="toastContainer" class="absolute left-1/2 -translate-x-1/2 top-0 z-50"></div>

        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider w-10">No.</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Anggota</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Buku</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Hari Terlambat</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Jumlah Denda</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Status</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>

            <tbody id="tableContainer">
                @include('petugas.denda.partials.table', ['data' => $data])
            </tbody>
        </table>

        <!-- Pagination AJAX -->
        <div id="paginationContainer">
            @include('components.pagination', ['paginator' => $data])
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/petugas-denda.js') }}"></script>
@endpush