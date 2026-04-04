@extends('layouts.dashboard_admin')

@section('title', 'Manajemen Kategori - SMARTELLIB')

@section('header')
<span class="text-2xl font-semibold">Kategori Buku</span>
@endsection

@section('content')
<div class="relative">

    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 mb-5">
        <span class="px-4 py-2 text-white text-sm font-semibold rounded-lg shadow-sm bg-cyan-900/80">
            Daftar Kategori Buku
        </span>
    </div>

    <!-- Top Section -->
    <div class="flex flex-wrap items-center gap-3 mb-5">

        <!-- Search -->
        <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-4 py-2.5 w-[250px] shadow-sm">
            <input type="text" id="searchInput" placeholder="Cari kategori..."
                    class="bg-transparent text-sm outline-none text-slate-700 w-full" />
        </div>

        <!-- Total -->
        <div id="totalKategoriBox"
            class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 shadow-sm">
            Total Kategori : {{ $data->total() }}
        </div>

        <!-- Button Tambah -->
        <a href="{{ route('admin.kategori.create') }}"
            class="ml-auto bg-cyan-900 hover:bg-cyan-800 text-white text-sm px-4 py-2.5 rounded-xl shadow-sm transition">
            Tambah Kategori
        </a>

    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200">

        <!-- TOAST -->
        <div id="toastContainer" class="absolute left-1/2 -translate-x-1/2 top-0 z-50"></div>

        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="text-center px-5 py-3.5 text-xs text-slate-400 uppercase">No.</th>
                    <th class="text-left px-5 py-3.5 text-xs text-slate-400 uppercase">Nama Kategori</th>
                    <th class="text-center px-5 py-3.5 text-xs text-slate-400 uppercase">Jumlah Buku</th>
                    <th class="text-center px-5 py-3.5 text-xs text-slate-400 uppercase">Aksi</th>
                </tr>
            </thead>

            <tbody id="tableContainer">
                @include('admin.kategori.partials.table', ['data' => $data])
            </tbody>
        </table>

        <div id="paginationContainer">
            @include('components.pagination', ['paginator' => $data])
        </div>
    </div>
</div>
@endsection
