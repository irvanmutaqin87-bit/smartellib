@extends('layouts.dashboard_admin')

@section('title', 'Tambah Petugas - SMARTELLIB')

@section('header')
<span class="text-2xl font-semibold">Tambah Petugas</span>
@endsection

@section('content')

<div class="relative max-w-5xl mx-auto">

    <!-- BREADCRUMB -->
    <div class="flex items-center justify-between mb-5">
        <span class="px-4 py-2 text-white text-sm font-semibold rounded-lg shadow-sm bg-cyan-900/80">
            Form Tambah Petugas
        </span>
    </div>

    <!-- CARD -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 relative overflow-visible">

        <div id="toastContainer" class="absolute left-1/2 -translate-x-1/2 -top-14 z-50"></div>

        <form id="petugasForm" action="{{ route('admin.petugas.store') }}" method="POST" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- NAMA -->
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">Nama Petugas</label>
                    <input type="text" name="nama"
                           value="{{ old('nama') }}"
                           class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:border-cyan-700 focus:ring-cyan-700"
                           placeholder="Masukkan nama petugas">
                    @error('nama')
                        <small class="text-red-500 text-xs mt-2 block">{{ $message }}</small>
                    @enderror
                </div>

                <!-- EMAIL -->
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">Email</label>
                    <input type="email" name="email"
                           value="{{ old('email') }}"
                           class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:border-cyan-700 focus:ring-cyan-700"
                           placeholder="Masukkan email petugas">
                    @error('email')
                        <small class="text-red-500 text-xs mt-2 block">{{ $message }}</small>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">Password</label>
                    <input type="text" name="password"
                           value="{{ old('password') }}"
                           class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:border-cyan-700 focus:ring-cyan-700"
                           placeholder="Masukkan password">
                    
                          <p class="text-xs text-gray-400 mb-6 ml-2 mt-2">
                              Password minimal 8 karakter, wajib huruf besar, huruf kecil, dan angka.
                          </p>

                    @error('password')
                        <small class="text-red-500 text-xs mt-2 block">{{ $message }}</small>
                    @enderror
                </div>

                <!-- KONFIRMASI PASSWORD -->
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">Konfirmasi Password</label>
                    <input type="text" name="password_confirmation"
                           value="{{ old('password_confirmation') }}"
                           class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:border-cyan-700 focus:ring-cyan-700"
                           placeholder="Ulangi password">
                    @error('password_confirmation')
                        <small class="text-red-500 text-xs mt-2 block">{{ $message }}</small>
                    @enderror
                </div>

                <!-- NO HP -->
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">Nomor HP</label>
                    <input type="text" name="no_hp"
                           value="{{ old('no_hp') }}"
                           class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:border-cyan-700 focus:ring-cyan-700"
                           placeholder="Masukkan nomor HP">
                    @error('no_hp')
                        <small class="text-red-500 text-xs mt-2 block">{{ $message }}</small>
                    @enderror
                </div>

<!-- STATUS CUSTOM DROPDOWN KHUSUS PETUGAS -->
<div class="relative z-40">
    <label class="block text-sm font-medium text-slate-600 mb-2">Status Akun</label>

    <div class="relative">
        <button type="button" id="petugasStatusBtn"
            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-600 shadow-sm cursor-pointer hover:border-cyan-700 outline-none focus:outline-none focus:ring-0 active:ring-0 transition-colors flex items-center justify-between">
            <span id="petugasStatusText">Pilih Status Akun</span>
            <svg id="petugasStatusIcon"
                xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4 transition-all duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div id="petugasStatusDropdown"
            class="absolute left-0 top-full mt-3 w-full bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-slate-200 p-2 z-[999]
            origin-top transform scale-y-95 opacity-0 -translate-y-2 pointer-events-none
            transition-all duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]">

            <button type="button"
                class="petugasStatusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-cyan-50 hover:text-cyan-800 text-sm text-slate-700 transition"
                data-value="aktif">
                Aktif
            </button>

            <button type="button"
                class="petugasStatusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-cyan-50 hover:text-cyan-800 text-sm text-slate-700 transition"
                data-value="nonaktif">
                Nonaktif
            </button>
        </div>

        <input type="hidden" name="status" id="petugasStatusInput" value="{{ old('status') }}">
    </div>

    @error('status')
        <small class="text-red-500 text-xs mt-2 block">{{ $message }}</small>
    @enderror
</div>
            </div>

            <!-- ACTION -->
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.petugas.index') }}"
                   class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition text-sm font-medium">
                    Batal
                </a>

                <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-cyan-900 text-white hover:bg-cyan-800 transition text-sm font-medium shadow-sm">
                    Simpan Petugas
                </button>
            </div>
        </form>
    </div>
</div>

@endsection