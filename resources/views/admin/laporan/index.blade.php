@extends('admin.dashboard')

@section('title', 'Laporan - SMARTELLIB')

@section('header')
<span class="text-2xl font-semibold">Laporan</span>
@endsection

@section('content')

<div class="relative">

<!-- Breadcrumb -->
<div class="flex items-center justify-between mb-5">
    <span class="px-4 py-2 text-white text-sm font-semibold rounded-lg shadow-sm bg-cyan-900/80">
        Laporan Sistem
    </span>

    <button
        class="bg-cyan-700 hover:bg-cyan-800 text-white text-sm px-4 py-2.5 rounded-xl shadow-sm transition">
        Export Laporan
    </button>
</div>

<!-- Filter -->
<div class="flex flex-wrap items-center gap-3 mb-5">

    <!-- Jenis Laporan -->
    <select class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 shadow-sm">
        <option>Semua Jenis</option>
        <option>Peminjaman</option>
        <option>Anggota</option>
        <option>Denda</option>
    </select>

    <!-- Periode -->
    <input type="date"
        class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 shadow-sm">

    <span class="text-slate-400 text-sm">-</span>

    <input type="date"
        class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 shadow-sm">

    <!-- Button -->
    <button
        class="bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm px-4 py-2.5 rounded-xl shadow-sm transition">
        Tampilkan
    </button>

</div>

<!-- Statistik -->
<div class="grid grid-cols-3 gap-4 mb-5">

    <div class="bg-white rounded-2xl p-4 border shadow-sm">
        <p class="text-xs text-slate-400">Total Data</p>
        <p class="text-xl font-semibold text-slate-700 mt-1">120</p>
    </div>

    <div class="bg-white rounded-2xl p-4 border shadow-sm">
        <p class="text-xs text-slate-400">Aktif</p>
        <p class="text-xl font-semibold text-green-600 mt-1">95</p>
    </div>

    <div class="bg-white rounded-2xl p-4 border shadow-sm">
        <p class="text-xs text-slate-400">Nonaktif</p>
        <p class="text-xl font-semibold text-red-500 mt-1">25</p>
    </div>

</div>

<!-- Table -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200">

    <div class="px-5 py-4 border-b flex justify-between items-center">
        <h2 class="text-sm font-semibold text-slate-700">
            Data Laporan
        </h2>

        <input 
            type="text"
            placeholder="Cari data..."
            class="border rounded-xl px-3 py-1.5 text-sm"
        />
    </div>

    <table class="w-full text-sm">

        <thead>
            <tr class="bg-slate-50 border-b">
                <th class="px-5 py-3 text-xs text-slate-400">No</th>
                <th class="px-5 py-3 text-xs text-slate-400">Nama</th>
                <th class="px-5 py-3 text-xs text-slate-400">Email</th>
                <th class="px-5 py-3 text-xs text-slate-400">Status</th>
                <th class="px-5 py-3 text-xs text-slate-400">Tanggal</th>
            </tr>
        </thead>

        <tbody>

            <tr class="border-b">
                <td class="px-5 py-3">1</td>
                <td class="px-5 py-3 font-medium">Budi</td>
                <td class="px-5 py-3">budi@gmail.com</td>
                <td class="px-5 py-3">
                    <span class="px-2 py-1 text-xs bg-green-100 text-green-600 rounded-lg">
                        Aktif
                    </span>
                </td>
                <td class="px-5 py-3 text-slate-500">12 Jan 2026</td>
            </tr>

            <tr class="border-b">
                <td class="px-5 py-3">2</td>
                <td class="px-5 py-3 font-medium">Siti</td>
                <td class="px-5 py-3">siti@gmail.com</td>
                <td class="px-5 py-3">
                    <span class="px-2 py-1 text-xs bg-red-100 text-red-600 rounded-lg">
                        Nonaktif
                    </span>
                </td>
                <td class="px-5 py-3 text-slate-500">15 Jan 2026</td>
            </tr>

        </tbody>

    </table>

</div>

</div>
@endsection