@extends('layouts.dashboard_petugas')

@section('title', 'Detail Antrian Peminjaman')

@section('header')
<span class="text-2xl font-semibold">Detail Antrian Peminjaman</span>
@endsection

@section('content')

<!-- Badge -->
<div class="flex items-center gap-2 mb-5">
    <span class="px-4 py-2 text-white text-sm font-semibold rounded-lg shadow-sm bg-cyan-900/80">
        Detail Antrian Peminjaman
    </span>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
    
    <div class="flex flex-col lg:flex-row gap-8">

        <!-- ================= KIRI ================= -->
        <div class="flex flex-col sm:flex-row gap-6 flex-1">

            <!-- COVER BUKU -->
            <div class="w-full sm:w-52 h-72 bg-slate-100 rounded-xl border border-slate-200 overflow-hidden flex items-center justify-center shrink-0">
                @if($antrian->buku->cover)
                    <img 
                        src="{{ asset('storage/' . $antrian->buku->cover) }}" 
                        class="w-full h-full object-cover"
                    >
                @else
                    <svg class="w-12 h-12 text-slate-300" fill="none" viewBox="0 0 24 24">
                        <path d="M6 4h12v16H6z" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                @endif
            </div>

            <!-- INFO -->
            <div class="flex-1">
                
                <h2 class="text-2xl font-bold text-slate-800">
                    {{ $antrian->buku->judul ?? '-' }}
                </h2>

                <p class="text-slate-400 text-sm mb-6">
                    {{ $antrian->anggota->user->nama ?? $antrian->anggota->nama_lengkap ?? '-' }}
                </p>

                <div class="space-y-3 text-sm">

                    <div class="flex gap-3">
                        <span class="w-40 text-slate-400">Kode Buku</span>
                        <span class="font-semibold text-slate-700">
                            : {{ $antrian->buku->kode_buku ?? '-' }}
                        </span>
                    </div>

                    <div class="flex gap-3">
                        <span class="w-40 text-slate-400">Tanggal Antrian</span>
                        <span class="font-semibold text-slate-700">
                            : {{ $antrian->created_at ? $antrian->created_at->format('d M Y H:i') : '-' }}
                        </span>
                    </div>

                    <div class="flex gap-3">
                        <span class="w-40 text-slate-400">Posisi Antrian</span>
                        <span class="font-semibold text-slate-700">
                            : {{ $antrian->posisi_antrian ?? '-' }}
                        </span>
                    </div>

                    <div class="flex gap-3 items-center">
                        <span class="w-40 text-slate-400">Status</span>

                        @if($antrian->status === 'menunggu')
                            <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">Menunggu</span>
                        @elseif($antrian->status === 'diproses')
                            <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">Diproses</span>
                        @elseif($antrian->status === 'selesai')
                            <span class="px-3 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700">Selesai</span>
                        @else
                            <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700">Dibatalkan</span>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <!-- ================= KANAN ================= -->
        <div class="w-full lg:w-72">
            <div class="bg-slate-50 rounded-xl border border-slate-200 overflow-hidden">

                <div class="bg-slate-200 px-4 py-2 font-semibold text-sm">
                    Informasi Ketersediaan
                </div>

                <div class="p-4 space-y-3 text-sm">

                    <div class="flex justify-between">
                        <span class="text-slate-400">Stok Buku</span>
                        <span>{{ $antrian->buku->stok ?? 0 }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-400">Kategori</span>
                        <span>{{ $antrian->buku->kategori->nama_kategori ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-400">Status Antrian</span>
                        <span class="font-semibold text-cyan-700">
                            {{ ucfirst($antrian->status) }}
                        </span>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- BUTTON -->
    <div class="mt-8 pt-6 border-t flex flex-wrap gap-3">
        <a href="{{ route('petugas.antrian.index') }}"
           class="px-6 py-2 bg-slate-100 hover:bg-slate-200 rounded-xl text-sm">
            Kembali
        </a>
    </div>

</div>

@endsection