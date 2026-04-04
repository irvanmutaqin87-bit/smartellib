@extends('layouts.dashboard_petugas')

@section('title', 'Tambah Buku Petugas - SMARTELLIB')

@section('header')
<span class="text-2xl font-semibold">Tambah Buku</span>
@endsection

@section('content')

<!-- Badge -->
<div class="flex items-center gap-2 mb-5">
    <span class="px-4 py-2 text-white text-sm font-semibold rounded-lg shadow-sm bg-cyan-900/80">
        Tambah Buku
    </span>
</div>

<!-- ================= CARD UTAMA ================= -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 relative">

    <form id="bukuForm" action="{{ route('petugas.buku.store') }}" method="POST" enctype="multipart/form-data" data-reset-on-success="true">
        @csrf

        <!-- ================= GRID UTAMA ================= -->
        <div class="flex flex-col xl:flex-row gap-6 items-stretch">

            <!-- ================= LEFT (FORM BUKU) ================= -->
            <div class="w-full xl:w-[65%] bg-white rounded-2xl border border-slate-200 shadow-sm overflow-visible">

                <div class="bg-slate-50 px-6 py-3 border-b border-slate-200 rounded-t-2xl">
                    <p class="font-bold text-slate-700 text-sm">Informasi Buku</p>
                </div>

                <div class="p-6 space-y-5">

                    <!-- ===== COVER BUKU ===== -->
                    <div class="flex flex-col md:flex-row gap-2 md:gap-4">
                        <label class="text-sm text-slate-500 w-32 shrink-0 pt-2">Cover Buku</label>
                        <span class="hidden md:block text-slate-400 mr-1 pt-2">:</span>

                        <div class="flex-1">
                            <div class="flex flex-col sm:flex-row gap-4 items-start">

                                <!-- Preview Cover -->
                                <div id="coverPreviewWrapper"
                                     class="w-36 h-52 bg-slate-100 rounded-xl border border-slate-200 flex items-center justify-center overflow-hidden shrink-0">
                                    <img id="coverPreview"
                                         src=""
                                         class="hidden w-full h-full object-cover" />

                                    <svg id="coverPlaceholder" width="40" height="40" fill="none" viewBox="0 0 24 24">
                                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" stroke="#cbd5e1" stroke-width="1.5"/>
                                    </svg>
                                </div>

                                <!-- Upload Cover -->
                                <div class="flex-1 w-full">
                                    <p class="text-sm text-slate-500 mb-3">Upload cover buku (JPG / PNG)</p>

                                    <label class="flex items-center gap-2 px-4 py-3 border-2 border-dashed border-slate-200 rounded-xl cursor-pointer hover:border-cyan-700 hover:bg-cyan-50 transition-colors text-sm text-slate-500">
                                        Pilih Cover Buku
                                        <input type="file" name="cover" id="coverInput" accept="image/*" class="hidden"/>
                                    </label>

                                    <p class="text-xs text-slate-400 mt-2">
                                        Rekomendasi ukuran cover: 600 × 900 px
                                    </p>

                                    <small class="text-red-500 text-xs mt-2 block error-message" data-field="cover"></small>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ===== JUDUL ===== -->
                    <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4">
                        <label class="text-sm text-slate-500 w-32 shrink-0">Judul Buku</label>
                        <span class="hidden md:block text-slate-400 mr-1">:</span>
                        <div class="flex-1">
                            <input type="text" name="judul" placeholder="Masukkan judul buku"
                                class="ajax-input w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 bg-white hover:border-cyan-700 outline-none focus:outline-none focus:ring-0 focus:border-cyan-700 transition-all"/>
                            <small class="text-red-500 text-xs mt-1 block error-message" data-field="judul"></small>
                        </div>
                    </div>

                    <!-- ===== KODE BUKU ===== -->
                    <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4">
                        <label class="text-sm text-slate-500 w-32 shrink-0">Kode Buku</label>
                        <span class="hidden md:block text-slate-400 mr-1">:</span>
                        <div class="flex-1">
                            <input type="text" name="kode_buku" value="{{ $kode_buku }}" readonly
                                class="ajax-input w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 bg-slate-100 outline-none"/>
                            <small class="text-red-500 text-xs mt-1 block error-message" data-field="kode_buku"></small>
                        </div>
                    </div>

                    <!-- ===== PENULIS ===== -->
                    <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4">
                        <label class="text-sm text-slate-500 w-32 shrink-0">Penulis</label>
                        <span class="hidden md:block text-slate-400 mr-1">:</span>
                        <div class="flex-1">
                            <input type="text" name="penulis" placeholder="Nama penulis"
                                class="ajax-input w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 bg-white hover:border-cyan-700 outline-none focus:outline-none focus:ring-0 focus:border-cyan-700 transition-all"/>
                            <small class="text-red-500 text-xs mt-1 block error-message" data-field="penulis"></small>
                        </div>
                    </div>

                    <!-- ===== PENERBIT ===== -->
                    <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4">
                        <label class="text-sm text-slate-500 w-32 shrink-0">Penerbit</label>
                        <span class="hidden md:block text-slate-400 mr-1">:</span>
                        <div class="flex-1">
                            <input type="text" name="penerbit" placeholder="Nama penerbit"
                                class="ajax-input w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 bg-white hover:border-cyan-700 outline-none focus:outline-none focus:ring-0 focus:border-cyan-700 transition-all"/>
                            <small class="text-red-500 text-xs mt-1 block error-message" data-field="penerbit"></small>
                        </div>
                    </div>

                    <!-- ===== TAHUN TERBIT ===== -->
                    <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4">
                        <label class="text-sm text-slate-500 w-32 shrink-0">Tahun Terbit</label>
                        <span class="hidden md:block text-slate-400 mr-1">:</span>
                        <div class="flex-1">
                            <input type="number" name="tahun_terbit" placeholder="Contoh: 2023"
                                class="ajax-input w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 bg-white hover:border-cyan-700 outline-none focus:outline-none focus:ring-0 focus:border-cyan-700 transition-all"/>
                            <small class="text-red-500 text-xs mt-1 block error-message" data-field="tahun_terbit"></small>
                        </div>
                    </div>

                    <!-- ===== TOTAL HALAMAN ===== -->
                    <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4">
                        <label class="text-sm text-slate-500 w-32 shrink-0">Total Halaman</label>
                        <span class="hidden md:block text-slate-400 mr-1">:</span>
                        <div class="flex-1">
                            <input type="number" name="total_halaman" placeholder="Jumlah halaman"
                                class="ajax-input w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 bg-white hover:border-cyan-700 outline-none focus:outline-none focus:ring-0 focus:border-cyan-700 transition-all"/>
                            <small class="text-red-500 text-xs mt-1 block error-message" data-field="total_halaman"></small>
                        </div>
                    </div>

                    <!-- ===== KATEGORI CUSTOM DROPDOWN ===== -->
                    <div class="flex flex-col md:flex-row md:items-start gap-2 md:gap-4 relative z-50">
                        <label class="text-sm text-slate-500 w-32 shrink-0 pt-2">Kategori</label>
                        <span class="hidden md:block text-slate-400 mr-1 pt-2">:</span>

                        <div class="flex-1 relative">
                            <button type="button" id="kategoriFilterBtn"
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 shadow-sm cursor-pointer hover:border-cyan-700 outline-none focus:outline-none focus:ring-0 active:ring-0 transition-colors flex items-center justify-between">
                                <span id="kategoriFilterText">Pilih Kategori</span>
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
                                class="absolute left-0 top-full mt-3 w-full bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-slate-200 p-2 z-[999]
                                origin-top transform scale-[0.98] opacity-0 translate-y-[-12px] pointer-events-none
                                transition-all duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]">

                                @foreach($kategori as $item)
                                    <button type="button"
                                        class="kategoriOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-cyan-50 hover:text-cyan-800 text-sm text-slate-700 transition"
                                        data-id="{{ $item->id }}">
                                        {{ $item->nama_kategori }}
                                    </button>
                                @endforeach
                            </div>

                            <!-- Hidden input -->
                            <input type="hidden" name="kategori_id" id="kategoriFilter" value="">
                            <small class="text-red-500 text-xs mt-2 block error-message" data-field="kategori_id"></small>
                        </div>
                    </div>

                    <!-- ===== STOK ===== -->
                    <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4">
                        <label class="text-sm text-slate-500 w-32 shrink-0">Stok Awal</label>
                        <span class="hidden md:block text-slate-400 mr-1">:</span>
                        <div class="flex-1">
                            <input type="number" name="stok" placeholder="Jumlah stok"
                                class="ajax-input w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 bg-white hover:border-cyan-700 outline-none focus:outline-none focus:ring-0 focus:border-cyan-700 transition-all"/>
                            <small class="text-red-500 text-xs mt-1 block error-message" data-field="stok"></small>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ================= RIGHT (KONTEN + DESKRIPSI) ================= -->
            <div class="w-full xl:w-[35%] flex flex-col gap-6">

                <!-- ===== FILE ===== -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="bg-slate-50 px-6 py-3 border-b border-slate-200">
                        <p class="font-bold text-slate-700 text-sm">Konten</p>
                    </div>

                    <div class="p-5">
                        <p class="text-sm text-slate-500 mb-1">Upload File E-Book</p>
                        <p class="text-sm text-slate-500 mb-3"> (PDF maksimal: 45 mb)</p>

                        <label class="flex items-center gap-2 px-4 py-3 border-2 border-dashed border-slate-200 rounded-xl cursor-pointer hover:border-cyan-700 hover:bg-cyan-50 transition-colors text-sm text-slate-500">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24">
                                <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <span id="pdfFileText">Pilih File PDF</span>
                            <input type="file" name="file_buku" id="pdfInput" accept=".pdf" class="hidden"/>
                        </label>

                        <p class="text-xs text-slate-400 mt-2" id="pdfFileName">Belum ada file dipilih</p>
                        <small class="text-red-500 text-xs mt-2 block error-message" data-field="file_buku"></small>
                    </div>
                </div>

                <!-- ===== DESKRIPSI ===== -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col flex-1 min-h-[420px]">
                    <div class="bg-slate-50 px-6 py-3 border-b border-slate-200">
                        <p class="font-bold text-slate-700 text-sm">Deskripsi Buku</p>
                    </div>

                    <div class="p-5 flex-1 flex flex-col">
                        <textarea
                            name="deskripsi"
                            class="ajax-input w-full h-full min-h-[300px] border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 resize-none bg-white hover:border-cyan-700 outline-none focus:outline-none focus:ring-0 focus:border-cyan-700 active:outline-none active:ring-0 transition-all"
                            placeholder="Masukkan deskripsi buku..."></textarea>
                        <small class="text-red-500 text-xs mt-2 block error-message" data-field="deskripsi"></small>
                    </div>
                </div>

            </div>
        </div>

        <!-- ================= BUTTON ================= -->
        <div class="flex flex-wrap items-center gap-3 mt-8 pt-6 border-t border-slate-100">

            <a href="{{ route('petugas.buku.index') }}"
                class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-colors">
                Kembali
            </a>

            <div class="flex-1"></div>

            <button type="reset" id="resetFormBtn"
                class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-colors">
                Reset
            </button>

            <button type="submit"
                class="px-6 py-2.5 text-white text-sm font-semibold rounded-xl shadow-sm
                bg-gradient-to-r from-cyan-700 to-cyan-900
                hover:from-cyan-800 hover:to-cyan-950 transition">
                Simpan Buku
            </button>

        </div>

    </form>

    <!-- TOAST -->
    <div id="toastContainer"
         class="absolute -top-20 left-1/2 -translate-x-1/2 z-50 space-y-2 pointer-events-none">
    </div>

</div>

@endsection