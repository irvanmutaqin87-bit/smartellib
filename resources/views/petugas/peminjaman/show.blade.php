@extends('layouts.dashboard_petugas')

@section('title', 'Detail Peminjaman')

@section('header')
<span class="text-2xl font-semibold">Detail Peminjaman</span>
@endsection

@section('content')

<!-- Badge -->
<div class="flex items-center gap-2 mb-5">
    <span class="px-4 py-2 text-white text-sm font-semibold rounded-lg shadow-sm bg-cyan-900/80">
        Detail Peminjaman
    </span>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
    
    <div class="flex flex-col lg:flex-row gap-8">

        <!-- ================= KIRI ================= -->
        <div class="flex flex-col sm:flex-row gap-6 flex-1">

            <!-- COVER BUKU -->
            <div class="w-full sm:w-52 h-72 bg-slate-100 rounded-xl border border-slate-200 overflow-hidden flex items-center justify-center shrink-0">
                @if($peminjaman->buku->cover)
                    <img 
                        src="{{ asset('storage/' . $peminjaman->buku->cover) }}" 
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
                    {{ $peminjaman->buku->judul ?? '-' }}
                </h2>

                <p class="text-slate-400 text-sm mb-6">
                    {{ $peminjaman->anggota->nama_lengkap ?? '-' }}
                </p>

                <div class="space-y-3 text-sm">

                    <div class="flex gap-3">
                        <span class="w-40 text-slate-400">Tanggal Pinjam</span>
                        <span class="font-semibold text-slate-700">
                            : {{ \Carbon\Carbon::parse($peminjaman->tanggal_mulai)->format('d M Y') }}
                        </span>
                    </div>

                    <div class="flex gap-3">
                        <span class="w-40 text-slate-400">Jatuh Tempo</span>
                        <span class="font-semibold text-slate-700">
                            : {{ \Carbon\Carbon::parse($peminjaman->tanggal_jatuh_tempo)->format('d M Y') }}
                        </span>
                    </div>

                    <div class="flex gap-3">
                        <span class="w-40 text-slate-400">Tanggal Kembali</span>
                        <span class="font-semibold text-slate-700">
                            : {{ $peminjaman->tanggal_kembali 
                                ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') 
                                : '-' }}
                        </span>
                    </div>

                    <div class="flex gap-3 items-center">
                        <span class="w-40 text-slate-400">Status</span>
                        @if($peminjaman->status === 'dipinjam')
                            <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">Dipinjam</span>
                        @elseif($peminjaman->status === 'dikembalikan')
                            <span class="px-3 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700">Dikembalikan</span>
                        @else
                            <span class="px-3 py-1 text-xs rounded-full bg-rose-100 text-rose-700">Terlambat</span>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <!-- ================= KANAN ================= -->
        <div class="w-full lg:w-72">
            <div class="bg-slate-50 rounded-xl border border-slate-200 overflow-hidden">

                <div class="bg-slate-200 px-4 py-2 font-semibold text-sm">
                    Informasi Denda
                </div>

                <div class="p-4 space-y-3 text-sm">

                    <div class="flex justify-between">
                        <span class="text-slate-400">Status</span>
                        <span>{{ $peminjaman->denda->status_denda ?? 'Tidak ada' }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-400">Terlambat</span>
                        <span>{{ $peminjaman->denda->hari_terlambat ?? 0 }} hari</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-400">Total</span>
                        <span class="text-red-500 font-semibold">
                            @if($peminjaman->denda)
                                Rp {{ number_format($peminjaman->denda->jumlah_denda, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </span>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- BUTTON -->
    <div class="mt-8 pt-6 border-t">
        <a href="{{ route('petugas.peminjaman.index') }}"
           class="px-6 py-2 bg-slate-100 hover:bg-slate-200 rounded-xl text-sm">
            Kembali
        </a>
    </div>

</div>

@endsection