@extends('layouts.dashboard_petugas')

@section('title', 'Manajemen Buku Petugas - SMARTELLIB')

@section('header')
<span class="text-2xl font-semibold">Manajemen Buku</span>
@endsection

@section('content')

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
        <input type="text" placeholder="Cari Judul Buku..." class="bg-transparent text-sm outline-none text-slate-700 placeholder-slate-400 w-full"/>
    </div>

<!-- ================= FILTER STATUS ================= -->
<div class="relative">
    <button id="statusFilterBtn"
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

    <div id="statusFilterDropdown"
          class="absolute left-0 mt-3 w-full bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border p-2 z-50
          origin-top transform scale-[0.98] opacity-0 translate-y-[-12px]
          transition-all duration-700 ease-[cubic-bezier(0.22,1,0.36,1)]">

        <button type="button" class="statusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition">Semua Status</button>
        <button type="button" class="statusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition">Tersedia</button>
        <button type="button" class="statusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition">Dipinjam</button>
        <button type="button" class="statusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition">Habis</button>
    </div>
</div>

<!-- ================= FILTER KATEGORI ================= -->
<div class="relative">
    <button id="kategoriFilterBtn"
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

    <div id="kategoriFilterDropdown"
          class="absolute left-0 mt-3 w-full bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border p-2 z-50
          origin-top transform scale-[0.98] opacity-0 translate-y-[-12px]
          transition-all duration-700 ease-[cubic-bezier(0.22,1,0.36,1)]">

        <button type="button" class="kategoriOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition">Semua Kategori</button>
        <button type="button" class="kategoriOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition">Self Development</button>
        <button type="button" class="kategoriOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition">Novel</button>
        <button type="button" class="kategoriOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition">Sains</button>
        <button type="button" class="kategoriOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition">Teknologi</button>
    </div>
</div>

    <!-- Button Tambah -->
    <a href="{{ route('petugas.tambah_buku') }}"
        class="ml-auto flex items-center gap-2 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow bg-cyan-900/80 hover:bg-cyan-800/80 transition-colors">
        Tambah Buku
    </a>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200">
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

        <tbody>
            <!-- ROW 1 -->
            <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                <td class="px-5 py-4 text-slate-600">1</td>
                <td class="px-5 py-4 font-medium text-slate-800">Atomic Habits</td>
                <td class="px-5 py-4 text-slate-600">James Clear</td>
                <td class="px-5 py-4 text-slate-600">Self Development</td>
                <td class="px-5 py-4 text-slate-600">12</td>
                <td class="px-5 py-4">
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600 border border-emerald-100">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Tersedia
                    </span>
                </td>
                <td class="px-5 py-4 text-center">
                    <div class="relative inline-block">
                      <button type="button"
                          class="bookActionBtn w-10 h-10 rounded-xl flex items-center justify-center hover:bg-slate-100 transition"
                          aria-label="Menu aksi">
                          <svg xmlns="http://www.w3.org/2000/svg"
                              class="w-5 h-5 text-slate-500"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                              stroke-width="2">
                              <circle cx="6" cy="12" r="1.2" fill="currentColor" stroke="none"/>
                              <circle cx="12" cy="12" r="1.2" fill="currentColor" stroke="none"/>
                              <circle cx="18" cy="12" r="1.2" fill="currentColor" stroke="none"/>
                          </svg>
                      </button>

                      <div class="bookActionDropdown absolute right-full top-1/2 -translate-y-1/2 mr-3 w-52 bg-white rounded-2xl shadow-xl border border-slate-200 p-2 z-50
                          origin-right scale-95 opacity-0 translate-x-2 pointer-events-none
                          transition-all duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)]">

                          <a href="{{ route('petugas.detail_buku') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-slate-700 hover:bg-slate-50 transition">
                              Detail Buku
                          </a>

                          <a href="{{ route('petugas.edit_buku') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-slate-700 hover:bg-slate-50 transition">
                              Edit Buku
                          </a>

                          <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-red-600 hover:bg-red-50 transition">
                              Hapus Buku
                          </a>
                      </div>
                  </div>
                </td>
            </tr>

        </tbody>
    </table>

    <!-- Pagination -->
    <div class="flex items-center justify-center gap-1.5 py-4 border-t border-slate-100">
        <button class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:bg-slate-100 transition-colors">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24">
                <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </button>

        <button class="w-8 h-8 rounded-lg text-white text-sm font-semibold bg-[#2563eb]">1</button>
        <button class="w-8 h-8 rounded-lg text-slate-500 hover:bg-slate-100 text-sm transition-colors">2</button>
        <button class="w-8 h-8 rounded-lg text-slate-500 hover:bg-slate-100 text-sm transition-colors">3</button>

        <button class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:bg-slate-100 transition-colors">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24">
                <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </button>
    </div>
</div>

@endsection