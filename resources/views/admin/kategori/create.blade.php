@extends('layouts.dashboard_admin')

@section('title', 'Manajemen Kategori Buku - SMARTELLIB')

@section('header')
<span class="text-2xl font-semibold">Manajemen Kategori Buku</span>
@endsection

@section('content')

<div class="relative">

    <!-- Breadcrumb -->
    <div class="mb-10">
        <span class="px-4 py-2 text-white text-sm font-semibold rounded-lg shadow-sm bg-cyan-900/80">
            Tambah Kategori Buku
        </span>
    </div>

    <!-- Form AJAX -->
    <form id="kategoriForm" action="{{ route('admin.kategori.store') }}" method="POST"
          class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        @csrf

        <!-- Input Nama Kategori -->
        <div class="mb-6">
            <label class="text-sm text-slate-500">Nama Kategori</label>
            <input 
                type="text"
                name="nama_kategori"
                placeholder="Masukkan nama kategori..."
                class="mt-2 w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:border-cyan-700 transition"
            />
        </div>

        <!-- Tombol -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.kategori.index') }}"
                class="bg-slate-300 hover:bg-slate-400 text-slate-700 text-sm px-5 py-2.5 rounded-xl transition">
                Kembali
            </a>

            <div class="flex gap-3">
                <button type="reset"
                    class="bg-slate-400 hover:bg-slate-500 text-white text-sm px-5 py-2.5 rounded-xl transition">
                    Batal
                </button>

                <button type="submit"
                    class="bg-cyan-700 hover:bg-cyan-800 text-white text-sm px-5 py-2.5 rounded-xl transition">
                    Simpan
                </button>
            </div>
        </div>
    </form>

    <!-- TOAST CONTAINER -->
    <div id="toastContainer"
        class="absolute top-0 left-1/2 -translate-x-1/2 z-50 space-y-2 pointer-events-none">
    </div>

</div>
@endsection