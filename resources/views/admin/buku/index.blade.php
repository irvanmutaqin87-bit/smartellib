@extends('layouts.dashboard_admin')

@section('title', 'Daftar Buku - SMARTELLIB')

@section('header')
<span class="text-2xl font-semibold">Daftar Buku</span>
@endsection

@section('content')

<div class="relative">

    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 mb-5">
        <span class="px-4 py-2 text-white text-sm font-semibold rounded-lg shadow-sm bg-cyan-900/80">
            Daftar Buku
        </span>
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap items-center gap-3 mb-5">

        <!-- Search -->
        <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-4 py-2.5 flex-1 min-w-[200px] max-w-xs shadow-sm">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8" stroke="#94a3b8" stroke-width="2"/>
                <path d="M21 21l-4.35-4.35" stroke="#94a3b8" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <input 
                type="text" 
                id="searchInput"
                placeholder="Cari Judul Buku..." 
                class="bg-transparent text-sm outline-none text-slate-700 placeholder-slate-400 w-full"
            />
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

            <!-- Hidden input untuk AJAX -->
            <input type="hidden" id="statusFilter" name="statusFilter" value="">

            <div id="statusFilterDropdown"
                class="absolute left-0 mt-3 w-full bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border p-2 z-50
                origin-top scale-y-95 opacity-0 -translate-y-2 pointer-events-none
                transition-all duration-300 ease-out">

                <button type="button" class="statusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="">
                    Semua Status
                </button>
                <button type="button" class="statusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="tersedia">
                    Tersedia
                </button>
                <button type="button" class="statusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="habis">
                    Habis
                </button>
            </div>
        </div>

        <!-- ================= FILTER KATEGORI ================= -->
        <div class="relative">
            <button id="kategoriFilterBtn"
                type="button"
                class="w-[220px] bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 shadow-sm cursor-pointer hover:border-cyan-700 transition-colors flex items-center justify-between">
                <span id="kategoriFilterText">Semua Kategori</span>
                <svg id="kategoriFilterIcon"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 transition-all duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Hidden input untuk AJAX -->
            <input type="hidden" id="kategoriFilter" name="kategoriFilter" value="">

            <div id="kategoriFilterDropdown"
                class="absolute left-0 mt-3 w-full bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border p-2 z-50
                origin-top scale-y-95 opacity-0 -translate-y-2 pointer-events-none
                transition-all duration-300 ease-out">

                <button type="button"
                    class="kategoriOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition"
                    data-id="">
                    Semua Kategori
                </button>

                @foreach($kategori as $item)
                    <button type="button"
                        class="kategoriOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition"
                        data-id="{{ $item->id }}">
                        {{ $item->nama_kategori }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Total -->
        <div id="totalBukuBox"
            class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 shadow-sm">
            Total Buku : {{ $data->total() }}
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-visible relative">

        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider w-10">No.</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Judul Buku</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Penulis</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Kategori</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Stok</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Status</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>

            <tbody id="tableContainer">
                @include('admin.buku.partials.table', ['data' => $data])
            </tbody>
        </table>

        <!-- Pagination AJAX -->
        <div id="paginationContainer">
            @include('components.pagination', ['paginator' => $data])
        </div>
    </div>
</div>

@endsection