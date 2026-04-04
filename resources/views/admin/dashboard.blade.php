@extends('layouts.dashboard_admin')

@section('title', 'Dashboard Admin - SMARTELLIB')

@section('header')
<span class="text-2xl font-semibold">Dashboard Admin</span>
@endsection

@section('content')

<div class="space-y-6">

    <!-- ================= STATISTIK ================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

        <div class="bg-white p-5 rounded-2xl border shadow-sm">
            <p class="text-sm text-slate-400">Total Buku</p>
            <h2 class="text-2xl font-bold text-slate-800 mt-1">120</h2>
        </div>

        <div class="bg-white p-5 rounded-2xl border shadow-sm">
            <p class="text-sm text-slate-400">Total Anggota</p>
            <h2 class="text-2xl font-bold text-slate-800 mt-1">85</h2>
        </div>

        <div class="bg-white p-5 rounded-2xl border shadow-sm">
            <p class="text-sm text-slate-400">Total Petugas</p>
            <h2 class="text-2xl font-bold text-slate-800 mt-1">6</h2>
        </div>

        <div class="bg-white p-5 rounded-2xl border shadow-sm">
            <p class="text-sm text-slate-400">Peminjaman Aktif</p>
            <h2 class="text-2xl font-bold text-blue-600 mt-1">32</h2>
        </div>

        <div class="bg-white p-5 rounded-2xl border shadow-sm">
            <p class="text-sm text-slate-400">Buku Terlambat</p>
            <h2 class="text-2xl font-bold text-red-600 mt-1">7</h2>
        </div>

        <div class="bg-white p-5 rounded-2xl border shadow-sm">
            <p class="text-sm text-slate-400">Denda Belum Lunas</p>
            <h2 class="text-2xl font-bold text-amber-600 mt-1">Rp 150.000</h2>
        </div>

    </div>

    <!-- ================= AKTIVITAS TERBARU ================= -->
<div class="bg-white rounded-2xl border shadow-sm p-6">

    <h3 class="text-sm font-semibold text-slate-500 mb-4 uppercase tracking-wider">
        Aktivitas Terbaru
    </h3>

    <div class="space-y-4 text-sm">

        <div class="flex justify-between items-center">
            <span class="text-slate-600">Budi melakukan peminjaman buku</span>
            <span class="text-slate-400 text-xs">2 menit lalu</span>
        </div>

        <div class="flex justify-between items-center">
            <span class="text-slate-600">Siti mendaftar sebagai anggota</span>
            <span class="text-slate-400 text-xs">10 menit lalu</span>
        </div>

        <div class="flex justify-between items-center">
            <span class="text-slate-600">Admin menambahkan buku baru</span>
            <span class="text-slate-400 text-xs">30 menit lalu</span>
        </div>

        <div class="flex justify-between items-center">
            <span class="text-slate-600">Denda baru dibuat</span>
            <span class="text-slate-400 text-xs">1 jam lalu</span>
        </div>

        <div class="flex justify-between items-center">
            <span class="text-slate-600">Pembayaran denda berhasil</span>
            <span class="text-slate-400 text-xs">2 jam lalu</span>
        </div>

    </div>

</div>

    <!-- ================= TABEL BUKU ================= -->
    <div class="bg-white rounded-2xl shadow-sm border">

        <div class="px-6 py-4 border-b">
            <h3 class="text-sm font-semibold text-slate-600">Daftar Buku</h3>
        </div>

        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b">
                    <th class="px-5 py-3 text-xs text-slate-400 text-left">Judul</th>
                    <th class="px-5 py-3 text-xs text-slate-400 text-left">Kategori</th>
                    <th class="px-5 py-3 text-xs text-slate-400 text-center">Stok</th>
                </tr>
            </thead>

            <tbody>

                <tr class="border-b hover:bg-slate-50">
                    <td class="px-5 py-3">Atomic Habits</td>
                    <td class="px-5 py-3">Self Development</td>
                    <td class="px-5 py-3 text-center">10</td>
                </tr>

                <tr class="border-b hover:bg-slate-50">
                    <td class="px-5 py-3">Clean Code</td>
                    <td class="px-5 py-3">Programming</td>
                    <td class="px-5 py-3 text-center">5</td>
                </tr>

                <tr class="hover:bg-slate-50">
                    <td class="px-5 py-3">Rich Dad Poor Dad</td>
                    <td class="px-5 py-3">Finance</td>
                    <td class="px-5 py-3 text-center">8</td>
                </tr>

            </tbody>
        </table>

    </div>

    <!-- ================= TABEL ANGGOTA ================= -->
    <div class="bg-white rounded-2xl shadow-sm border">

        <div class="px-6 py-4 border-b">
            <h3 class="text-sm font-semibold text-slate-600">Daftar Anggota</h3>
        </div>

        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b">
                    <th class="px-5 py-3 text-xs text-slate-400 text-left">Nama</th>
                    <th class="px-5 py-3 text-xs text-slate-400 text-left">Email</th>
                    <th class="px-5 py-3 text-xs text-slate-400 text-center">Status</th>
                </tr>
            </thead>

            <tbody>

                <tr class="border-b hover:bg-slate-50">
                    <td class="px-5 py-3">Budi Santoso</td>
                    <td class="px-5 py-3">budi@gmail.com</td>
                    <td class="px-5 py-3 text-center">
                        <span class="px-3 py-1 text-xs bg-emerald-50 text-emerald-600 rounded-full">
                            Aktif
                        </span>
                    </td>
                </tr>

                <tr class="border-b hover:bg-slate-50">
                    <td class="px-5 py-3">Siti Aminah</td>
                    <td class="px-5 py-3">siti@gmail.com</td>
                    <td class="px-5 py-3 text-center">
                        <span class="px-3 py-1 text-xs bg-yellow-50 text-yellow-600 rounded-full">
                            Pending
                        </span>
                    </td>
                </tr>

                <tr class="hover:bg-slate-50">
                    <td class="px-5 py-3">Andi Wijaya</td>
                    <td class="px-5 py-3">andi@gmail.com</td>
                    <td class="px-5 py-3 text-center">
                        <span class="px-3 py-1 text-xs bg-slate-100 text-slate-600 rounded-full">
                            Nonaktif
                        </span>
                    </td>
                </tr>

            </tbody>
        </table>

    </div>

</div>

@endsection