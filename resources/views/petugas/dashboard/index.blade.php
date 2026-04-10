@extends('layouts.dashboard_petugas')

@section('title', 'Dashboard Petugas - SMARTELLIB')

@section('header')
<span class="text-2xl font-semibold">Dashboard Petugas</span>
@endsection

@section('content')

<div class="space-y-6">

    <!-- ================= STATISTIK ================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="bg-white p-5 rounded-2xl border shadow-sm">
            <p class="text-xs text-slate-400">Total Buku</p>
            <h2 class="text-xl font-bold">{{ $totalBuku }}</h2>
        </div>

        <div class="bg-white p-5 rounded-2xl border shadow-sm">
            <p class="text-xs text-slate-400">Anggota</p>
            <h2 class="text-xl font-bold">{{ $totalAnggota }}</h2>
        </div>

        <div class="bg-white p-5 rounded-2xl border shadow-sm">
            <p class="text-xs text-slate-400">Peminjaman</p>
            <h2 class="text-xl font-bold text-blue-600">
                {{ $totalPeminjaman }}
            </h2>
        </div>

        <div class="bg-white p-5 rounded-2xl border shadow-sm">
            <p class="text-xs text-slate-400">Total Denda</p>
            <h2 class="text-xl font-bold text-amber-600">
                Rp {{ number_format($totalDenda,0,',','.') }}
            </h2>
        </div>

    </div>

    <!-- ================= GRAFIK ================= -->
    <div class="bg-white rounded-2xl border p-6">

        <div class="flex justify-between items-center mb-4">

            <h3 class="text-sm font-semibold text-slate-500 uppercase">
                Grafik Peminjaman
            </h3>

            <div class="relative">
                <button id="chartFilterBtn"
                    class="bg-white border rounded-xl px-4 py-2 text-sm w-[160px] flex justify-between items-center">

                    <span id="chartFilterText">Bulanan</span>

                    <svg id="chartFilterIcon"
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 transition-all duration-300"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <input type="hidden" id="chartFilter" value="bulanan">

                <<div id="chartFilterDropdown"
                    class="absolute w-full bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border p-2 z-50
                    origin-top transform scale-[0.95] opacity-0 -translate-y-3 pointer-events-none
                    transition-all duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]">

                    <button class="chartOption w-full text-left px-3 py-2 hover:bg-slate-100 rounded-lg" data-value="harian">Harian</button>
                    <button class="chartOption w-full text-left px-3 py-2 hover:bg-slate-100 rounded-lg" data-value="bulanan">Bulanan</button>
                    <button class="chartOption w-full text-left px-3 py-2 hover:bg-slate-100 rounded-lg" data-value="tahunan">Tahunan</button>

                </div>
            </div>

        </div>

        <canvas id="peminjamanChart" height="100"></canvas>
    </div>

    <!-- ================= 3 GRID ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- PEMINJAMAN -->
        <div class="bg-white rounded-2xl border shadow-sm">
            <div class="px-4 py-3 border-b text-sm font-semibold text-slate-600">
                Peminjaman Terbaru
            </div>

            <div class="divide-y text-sm">
                @foreach($peminjaman as $item)
                <div class="p-4 flex justify-between">
                    <span>{{ $item->anggota->user->nama ?? '-' }}</span>
                    <span class="text-slate-400">
                        {{ $item->created_at->diffForHumans() }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- BUKU -->
        <div class="bg-white rounded-2xl border shadow-sm">
            <div class="px-4 py-3 border-b text-sm font-semibold text-slate-600">
                Buku Terbaru
            </div>

            <div class="divide-y text-sm">
                @foreach($buku as $item)
                <div class="p-4 flex justify-between">
                    <span>{{ $item->judul }}</span>
                    <span class="text-slate-400">
                        Stok: {{ $item->stok }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- ANGGOTA -->
        <div class="bg-white rounded-2xl border shadow-sm">
            <div class="px-4 py-3 border-b text-sm font-semibold text-slate-600">
                Anggota Terbaru
            </div>

            <div class="divide-y text-sm">
                @foreach($anggota as $item)
                <div class="p-4 flex justify-between">
                    <span>{{ $item->nama }}</span>
                    <span class="text-slate-400">Baru</span>
                </div>
                @endforeach
            </div>
        </div>

    </div>

</div>

{{-- DATA CHART --}}
<script>
    window.chartLabels = @json($labels);
    window.chartData = @json($data);
</script>

@endsection