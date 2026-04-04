@extends('layouts.dashboard_petugas')

@section('title', 'Detail Anggota - SMARTELLIB')

@section('header')
<span class="text-2xl font-semibold">Detail Anggota</span>
@endsection

@section('content')

<div class="relative max-w-3xl mx-auto">


<!-- BREADCRUMB -->
<div class="flex items-center justify-between mb-5">

    <span class="px-4 py-2 text-white text-sm font-semibold rounded-lg shadow-sm bg-cyan-900/80">
        Detail Anggota
    </span>

</div>


<!-- CARD -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">

      <!-- TOAST CONTAINER -->
    <div id="toastContainer"
        class="absolute left-1/2 -translate-x-1/2 top-0 z-50">
    </div>
    
    <!-- HEADER -->
    <div class="flex items-center gap-5 mb-8">

        <!-- AVATAR -->
        <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center text-xl font-semibold text-slate-600">
            {{ strtoupper(substr($user->nama,0,1)) }}
        </div>

        <div>
            <h2 class="text-xl font-semibold text-slate-800">
                {{ $user->nama }}
            </h2>

            <p class="text-sm text-slate-500">
                {{ $user->email }}
            </p>

            <!-- STATUS -->
            <div id="statusBadge" class="mt-2">

                @if ($user->status == 'aktif')
                <span class="px-3 py-1 text-xs rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100">
                    Aktif
                </span>

                @elseif ($user->status == 'pending')
                <span class="px-3 py-1 text-xs rounded-full bg-yellow-50 text-yellow-600 border border-yellow-100">
                    Pending
                </span>

                @else
                <span class="px-3 py-1 text-xs rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                    Nonaktif
                </span>
                @endif

            </div>
        </div>

    </div>


    <!-- INFORMASI ANGGOTA -->
    <div class="mb-8">

        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-4">
            Informasi Anggota
        </h3>

        <div class="grid grid-cols-2 gap-6 text-sm">

            <div>
                <p class="text-slate-400 mb-1">Nama</p>
                <p class="text-slate-800 font-medium">
                    {{ $user->nama }}
                </p>
            </div>

            <div>
                <p class="text-slate-400 mb-1">Email</p>
                <p class="text-slate-800 font-medium">
                    {{ $user->email }}
                </p>
            </div>

            <div>
                <p class="text-slate-400 mb-1">Nomor HP</p>
                <p class="text-slate-800 font-medium">
                    {{ $user->anggota->no_hp ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-slate-400 mb-1">Alamat</p>
                <p class="text-slate-800 font-medium">
                    {{ $user->anggota->alamat ?? '-' }}
                </p>
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
                    {{ $user->created_at->format('d M Y H:i') }}
                </p>
            </div>

            <div>
                <p class="text-slate-400 mb-1">Terakhir Diperbarui</p>
                <p class="text-slate-800 font-medium">
                    {{ $user->updated_at->format('d M Y H:i') }}
                </p>
            </div>

        </div>

    </div>


    <!-- ACTION -->
<div class="mt-8 flex flex-col sm:flex-row sm:justify-between gap-3">

    <!-- ACTION -->
    <div class="flex gap-3 flex-wrap">
      @if ($user->status == 'pending')
      <button 
          class="ajaxAction actionBtn px-5 py-2 rounded-xl bg-emerald-500 text-white text-sm"
          data-url="{{ route('petugas.anggota.verifikasi',$user->id) }}"
          data-confirm="Verifikasi anggota ini?"
          data-next="aktif"
      >
          Verifikasi Anggota
      </button>

      @elseif ($user->status == 'aktif')
      <button 
          class="ajaxAction actionBtn px-5 py-2 rounded-xl bg-red-500 text-white text-sm"
          data-url="{{ route('petugas.anggota.nonaktifkan',$user->id) }}"
          data-confirm="Nonaktifkan anggota ini?"
          data-next="nonaktif"
      >
          Nonaktifkan Anggota
      </button>

      @elseif ($user->status == 'nonaktif')
      <button 
          class="ajaxAction actionBtn px-5 py-2 rounded-xl bg-blue-500 text-white text-sm"
          data-url="{{ route('petugas.anggota.aktifkan',$user->id) }}"
          data-confirm="Aktifkan kembali anggota ini?"
          data-next="aktif"
      >
          Aktifkan Anggota
      </button>
      @endif
    </div>

    <!-- KEMBALI -->
    <a href="{{ route('petugas.anggota.index') }}"
        class="px-5 py-2 rounded-xl bg-cyan-900 text-white text-sm hover:bg-cyan-800 transition text-center">
        Kembali
    </a>

</div>

</div>

</div>

@endsection