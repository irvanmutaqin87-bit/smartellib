@extends('layouts.dashboard_petugas')

@section('title', 'Dashboard Petugas - SMARTELLIB')

@section('header')
<span class="text-2xl font-semibold">Dashboard</span>
@endsection

@section('content')

<div class="grid grid-cols-4 gap-6 mb-10">

                <div class="bg-white rounded-2xl shadow p-6">
                    <p class="text-slate-500 mb-2">Total Anggota</p>
                    <h3 class="text-3xl font-bold text-cyan-600">120</h3>
                </div>

                <div class="bg-white rounded-2xl shadow p-6">
                    <p class="text-slate-500 mb-2">Menunggu Verifikasi</p>
                    <h3 class="text-3xl font-bold text-yellow-500">8</h3>
                </div>

                <div class="bg-white rounded-2xl shadow p-6">
                    <p class="text-slate-500 mb-2">Buku Dipinjam</p>
                    <h3 class="text-3xl font-bold text-blue-500">45</h3>
                </div>

                <div class="bg-white rounded-2xl shadow p-6">
                    <p class="text-slate-500 mb-2">Denda Aktif</p>
                    <h3 class="text-3xl font-bold text-red-500">3</h3>
                </div>

</div>

@endsection