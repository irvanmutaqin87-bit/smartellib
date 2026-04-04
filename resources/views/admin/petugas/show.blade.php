@extends('layouts.dashboard_admin')

@section('title', 'Detail Petugas - SMARTELLIB')

@section('header')
<span class="text-2xl font-semibold">Detail Petugas</span>
@endsection

@section('content')

<div class="relative max-w-3xl mx-auto">

    <!-- BREADCRUMB -->
    <div class="flex items-center justify-between mb-5">
        <span class="px-4 py-2 text-white text-sm font-semibold rounded-lg shadow-sm bg-cyan-900/80">
            Detail Petugas
        </span>
    </div>

    <!-- CARD -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">

        <div id="toastContainer"
            class="absolute left-1/2 -translate-x-1/2 top-0 z-50">
        </div>
        
        <!-- HEADER -->
        <div class="flex items-center gap-5 mb-8">

            <img src="{{ $petugas->user->photo ?? 'https://ui-avatars.com/api/?name=' . urlencode($petugas->user->nama) . '&background=06b6d4&color=fff' }}"
                 alt="Foto Petugas"
                 class="w-16 h-16 rounded-full object-cover border border-slate-200">

            <div>
                <h2 class="text-xl font-semibold text-slate-800">
                    {{ $petugas->user->nama }}
                </h2>

                <p class="text-sm text-slate-500">
                    {{ $petugas->user->email }}
                </p>

                <!-- STATUS -->
                <div id="statusBadge" class="mt-2">
                    @if ($petugas->user->status == 'aktif')
                        <span class="px-3 py-1 text-xs rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100">
                            Aktif
                        </span>
                    @else
                        <span class="px-3 py-1 text-xs rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                            Nonaktif
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- INFORMASI PETUGAS -->
        <div class="mb-8">
            <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-4">
                Informasi Petugas
            </h3>

            <div class="grid grid-cols-2 gap-6 text-sm">

                <div>
                    <p class="text-slate-400 mb-1">Nama</p>
                    <p class="text-slate-800 font-medium">{{ $petugas->user->nama }}</p>
                </div>

                <div>
                    <p class="text-slate-400 mb-1">Email</p>
                    <p class="text-slate-800 font-medium">{{ $petugas->user->email }}</p>
                </div>

                <div>
                    <p class="text-slate-400 mb-1">Nomor HP</p>
                    <p class="text-slate-800 font-medium">{{ $petugas->no_hp ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-slate-400 mb-1">Role</p>
                    <p class="text-slate-800 font-medium capitalize">{{ $petugas->user->role }}</p>
                </div>

            </div>
        </div>

        <!-- INFORMASI AKUN -->
        <div class="mb-8">
            <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-4">
                Informasi Akun
            </h3>

            <div class="grid grid-cols-2 gap-6 text-sm">

                <div>
                    <p class="text-slate-400 mb-1">Terdaftar Pada</p>
                    <p class="text-slate-800 font-medium">
                        {{ $petugas->user->created_at->format('d M Y H:i') }}
                    </p>
                </div>

                <div>
                    <p class="text-slate-400 mb-1">Terakhir Diperbarui</p>
                    <p class="text-slate-800 font-medium">
                        {{ $petugas->user->updated_at->format('d M Y H:i') }}
                    </p>
                </div>

                <div>
                    <p class="text-slate-400 mb-1">Terakhir Login</p>
                    <p class="text-slate-800 font-medium">
                        {{ $petugas->user->last_login_at ? \Carbon\Carbon::parse($petugas->user->last_login_at)->format('d M Y H:i') : '-' }}
                    </p>
                </div>

            </div>
        </div>

<!-- ACTION -->
<div class="mt-8 flex flex-col sm:flex-row sm:justify-between gap-3">

    <div id="detailActionContainer" class="flex gap-3 flex-wrap">
        @if ($petugas->user->status == 'aktif')
            <button 
                id="togglePetugasStatusBtn"
                class="ajaxAction actionBtn px-5 py-2 rounded-xl bg-red-500 text-white text-sm"
                data-url="{{ route('admin.petugas.toggle-status', $petugas->id) }}"
                data-method="PATCH"
                data-confirm="Nonaktifkan petugas ini?"
                data-next="nonaktif"
            >
                Nonaktifkan Petugas
            </button>
        @else
            <button 
                id="togglePetugasStatusBtn"
                class="ajaxAction actionBtn px-5 py-2 rounded-xl bg-blue-500 text-white text-sm"
                data-url="{{ route('admin.petugas.toggle-status', $petugas->id) }}"
                data-method="PATCH"
                data-confirm="Aktifkan kembali petugas ini?"
                data-next="aktif"
            >
                Aktifkan Petugas
            </button>
        @endif
    </div>

    <a href="{{ route('admin.petugas.index') }}"
        class="px-5 py-2 rounded-xl bg-cyan-900 text-white text-sm hover:bg-cyan-800 transition text-center">
        Kembali
    </a>
</div>

    </div>
</div>

@endsection