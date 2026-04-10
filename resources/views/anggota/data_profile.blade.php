@extends('layouts.app')

@section('title','Profile - SMARTELLIB')

@section('content')

<section class="py-24">
    
    <!-- TOAST SUCCESS -->
    @if(session('success'))
        <div class="absolute top-6 left-1/2 -translate-x-1/2 z-50">
            <div class="backdrop-blur-xl bg-emerald-400/20 border border-emerald-300/40 
                        text-emerald-900 px-6 py-3 rounded-xl shadow-xl 
                        text-sm font-medium animate-fade-in">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- TOAST ERROR (DINAMIS DARI CONTROLLER) -->
    @if(session('error'))
        <div class="absolute top-6 left-1/2 -translate-x-1/2 z-50">
            <div class="backdrop-blur-xl bg-red-400/20 border border-red-300/40 
                        text-red-900 px-6 py-3 rounded-xl shadow-xl 
                        text-sm font-medium animate-fade-in">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <main class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">


        <!-- ================= HEADER PROFILE ================= -->
        <section class="text-center p-12 bg-gradient-to-br from-cyan-50 to-white">

            <div class="relative w-28 mx-auto">

                <!-- FORM UPLOAD FOTO -->
                <form action="{{ route('anggota.profile.photo') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- AVATAR -->
                    @if(auth()->user()->photo)
                        <img 
                            src="{{ asset('storage/'.auth()->user()->photo) }}"
                            class="
                                w-28 h-28 rounded-full object-cover
                                ring-2 ring-cyan-300/40
                                shadow-[0_0_12px_rgba(34,211,238,0.45)]
                                hover:scale-105
                                hover:shadow-[0_0_18px_rgba(34,211,238,0.65)]
                                transition duration-300
                                mt-6
                            "
                        >
                    @else
                        <div
                            class="
                                w-28 h-28 rounded-full
                                bg-gradient-to-br from-cyan-500 to-cyan-500
                                text-white font-semibold text-3xl
                                flex items-center justify-center
                                ring-2 ring-cyan-300/40
                                shadow-[0_0_12px_rgba(34,211,238,0.45)]
                                hover:scale-105
                                hover:shadow-[0_0_18px_rgba(34,211,238,0.65)]
                                transition duration-300
                                mt-6
                            "
                        >
                            {{ strtoupper(substr(auth()->user()->nama ?? 'IM',0,2)) }}
                        </div>
                    @endif

                    <!-- CAMERA BUTTON -->
                    <label
                        class="
                            absolute bottom-0 right-0
                            w-9 h-9 rounded-full
                            bg-white
                            flex items-center justify-center
                            cursor-pointer
                            ring-2 ring-cyan-300/40
                            shadow-[0_0_12px_rgba(34,211,238,0.45)]
                            hover:scale-105
                            hover:shadow-[0_0_18px_rgba(34,211,238,0.65)]
                            transition duration-300
                        "
                    >

                        <!-- ICON KAMERA (TETAP SVG KAMU) -->
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 text-cyan-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 7h4l2-2h6l2 2h4v12H3z"/>

                            <circle cx="12"
                                    cy="13"
                                    r="4"
                                    stroke="currentColor"
                                    stroke-width="2"/>
                        </svg>

                        <!-- INPUT FILE -->
                        <input type="file" name="photo" class="hidden"
                            onchange="this.form.submit()">

                    </label>

                </form>

            </div>



            <!-- ================= PROFILE TAB ================= -->
            <div class="mt-10">

                <div class="relative flex justify-center gap-12 border-b pb-3">

                    <button
                        onclick="switchTab(0)"
                        class="tab-link text-gray-500 font-medium hover:text-cyan-600 transition"
                    >
                        Data Identitas
                    </button>

                    <button
                        onclick="switchTab(1)"
                        class="tab-link text-gray-500 font-medium hover:text-cyan-600 transition"
                    >
                        Ubah Profile
                    </button>

                    <span
                        id="tabIndicator"
                        class="absolute bottom-0 h-[2px] bg-cyan-500 rounded transition-all duration-300">
                    </span>

                </div>

            </div>

        </section>



        <!-- ================= PROFILE CONTENT ================= -->
        <section class="py-12">

            <div class="overflow-hidden">

                <div id="tabContent" class="flex transition-transform duration-500">


                    <!-- ================= DATA IDENTITAS ================= -->
                    <div class="min-w-full px-12">

                        <h2 class="text-xl text-cyan-700 font-semibold mb-10">
                            Data Pengguna
                        </h2>


                        <div class="space-y-10">

                            <div class="pb-2 border-b">
                                <p class="text-gray-500 text-sm mb-4">Nama Lengkap</p>
                                <p class="text-gray-800 font-medium">
                                    {{ auth()->user()->nama ?? '-' }}
                                </p>
                            </div>

                            <div class="pb-2 border-b">
                                <p class="text-gray-500 text-sm mb-4">Email</p>
                                <p class="text-gray-800 font-medium">
                                    {{ auth()->user()->email ?? '-' }}
                                </p>
                            </div>

                            <div class="pb-2 border-b">
                                <p class="text-gray-500 text-sm mb-4">Nomor Ponsel</p>
                                <p class="text-gray-800 font-medium">
                                    {{ auth()->user()->anggota->no_hp ?? '-' }}
                                </p>
                            </div>

                            <div class="pb-4 border-b">
                                <p class="text-gray-500 text-sm mb-4">Alamat Lengkap</p>
                                <p class="text-gray-800 font-medium">
                                    {{ auth()->user()->anggota->alamat ?? '-' }}
                                </p>
                            </div>

                        </div>

                    </div>



                    <!-- ================= EDIT PROFILE ================= -->
                    <div class="min-w-full px-12">

                        <div>

                            <h2 class="text-xl text-cyan-700 font-semibold mb-8">
                                Data Profil
                            </h2>


                        <form method="POST" action="{{ route('anggota.profile.update') }}" class="space-y-6 mb-6">
                            @csrf
                            @method('PUT')

                                <input type="text" name="nama" value="{{ auth()->user()->nama }}"
                                    placeholder="Nama Lengkap"
                                    class="
                                        w-full px-4 py-3 rounded-xl text-sm
                                        bg-gradient-to-br from-cyan-100/60 to-white/40
                                        border border-white/50
                                        backdrop-blur-md
                                        shadow-sm
                                        focus:ring-2 focus:ring-cyan-400/60
                                        focus:border-cyan-400
                                        hover:shadow-md
                                        outline-none
                                        transition-all duration-300
                                    "
                                >


                                <input
                                    type="email"
                                    name="email"
                                    value="{{ auth()->user()->email }}"
                                    placeholder="Email"
                                    class="
                                        w-full px-4 py-3 rounded-xl text-sm
                                        bg-gradient-to-br from-cyan-100/60 to-white/40
                                        border border-white/50
                                        backdrop-blur-md
                                        shadow-sm
                                        focus:ring-2 focus:ring-cyan-400/60
                                        focus:border-cyan-400
                                        hover:shadow-md
                                        outline-none
                                        transition-all duration-300
                                    "
                                >


                                <input
                                    type="text"
                                    name="phone"
                                    value="{{ auth()->user()->anggota->no_hp ?? '' }}"
                                    placeholder="Nomor Ponsel"
                                    class="
                                        w-full px-4 py-3 rounded-xl text-sm
                                        bg-gradient-to-br from-cyan-100/60 to-white/40
                                        border border-white/50
                                        backdrop-blur-md
                                        shadow-sm
                                        focus:ring-2 focus:ring-cyan-400/60
                                        focus:border-cyan-400
                                        hover:shadow-md
                                        outline-none
                                        transition-all duration-300
                                    "
                                >


                                <input
                                    type="text"
                                    name="alamat"
                                    value="{{ auth()->user()->anggota->alamat ?? '' }}"
                                    placeholder="Alamat Lengkap"
                                    class="
                                        w-full px-4 py-3 rounded-xl text-sm
                                        bg-gradient-to-br from-cyan-100/60 to-white/40
                                        border border-white/50
                                        backdrop-blur-md
                                        shadow-sm
                                        focus:ring-2 focus:ring-cyan-400/60
                                        focus:border-cyan-400
                                        hover:shadow-md
                                        outline-none
                                        transition-all duration-300
                                    "
                                >


                                <!-- BUTTON -->
                                <button
                                    type="submit"
                                    class="
                                        px-10 py-3 text-sm
                                        rounded-lg
                                        bg-cyan-500
                                        hover:bg-cyan-600
                                        text-white
                                        shadow-md
                                        transition duration-300
                                        mb-10
                                    "
                                >
                                    Simpan Perubahan
                                </button>

                            </form>



                            <!-- ================= PENGATURAN AKUN ================= -->
                            <div class="mt-12 bg-gray-50 rounded-xl p-8 border shadow-sm">

                                <h3 class="text-lg font-semibold text-gray-700 mb-6">
                                    Pengaturan Akun
                                </h3>

                                <div class="space-y-5">

                                    <input
                                        type="password"
                                        value="***************"
                                        disabled
                                        class="
                                            w-full px-4 py-3 rounded-xl text-sm
                                            bg-gray-100
                                            border border-gray-200
                                            outline-none
                                            mb-2
                                        "
                                    >
                                    <button
                                        id="openPasswordModal"
                                        type="button"
                                        class="text-cyan-600 text-sm hover:underline"
                                    >
                                        Ubah kata sandi?
                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>


                </div>

            </div>

        </section>

    </main>

</section>

<!-- ================= MODAL UBAH PASSWORD ================= -->
<div 
    id="passwordModal"
    class="fixed inset-0 z-50 flex items-center justify-center
    bg-black/40 backdrop-blur-sm
    opacity-0 pointer-events-none
    transition-all duration-300">

    <!-- CARD -->
    <div 
        id="passwordCard"
        class="
        bg-white rounded-2xl shadow-2xl w-[420px] p-8
        opacity-0 scale-90 translate-y-6
        transition-all duration-300 ease-out
        ">

        <h3 class="text-xl font-semibold text-gray-800 mb-6">
            Ubah Kata Sandi
        </h3>

        <form method="POST" action="{{ route('anggota.profile.password') }}" class="space-y-5">
            @csrf

            <!-- PASSWORD LAMA -->
            <div class="relative">
                <input
                    type="password"
                    name="old_password"
                    id="old_password"
                    placeholder="Password Lama"
                    class="w-full px-4 py-3 rounded-xl text-sm
                    bg-gradient-to-br from-cyan-100/60 to-white/40
                    border border-white/50
                    backdrop-blur-md
                    shadow-sm
                    focus:ring-2 focus:ring-cyan-400/60
                    focus:border-cyan-400
                    hover:shadow-md
                    outline-none transition-all duration-300
                    @error('old_password') border-red-400 ring-2 ring-red-300 @enderror">

                <span id="toggleOldPassword"
                    class="absolute right-4 top-3 text-slate-500 cursor-pointer hover:text-cyan-600 transition">
                </span>
            </div>

            @error('old_password')
            <p class="text-xs text-red-500 ml-1">
                {{ $message }}
            </p>
            @enderror


            <!-- PASSWORD BARU -->
            <div class="relative">
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Password Baru"
                    class="w-full px-4 py-3 rounded-xl text-sm
                    bg-gradient-to-br from-cyan-100/60 to-white/40
                    border border-white/50
                    backdrop-blur-md
                    shadow-sm
                    focus:ring-2 focus:ring-cyan-400/60
                    focus:border-cyan-400
                    hover:shadow-md
                    outline-none transition-all duration-300
                    @error('password') border-red-400 ring-2 ring-red-300 @enderror">

                <span id="togglePassword"
                    class="absolute right-4 top-3 text-slate-500 cursor-pointer hover:text-cyan-600 transition">
                </span>
            </div>

            @error('password')
            <p class="text-xs text-red-500 ml-1">
                {{ $message }}
            </p>
            @enderror


            <!-- KONFIRMASI PASSWORD -->
            <div class="relative">
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    placeholder="Konfirmasi Password Baru"
                    class="w-full px-4 py-3 rounded-xl text-sm
                    bg-gradient-to-br from-cyan-100/60 to-white/40
                    border border-white/50
                    backdrop-blur-md
                    shadow-sm
                    focus:ring-2 focus:ring-cyan-400/60
                    focus:border-cyan-400
                    hover:shadow-md
                    outline-none transition-all duration-300
                    @error('password_confirmation') border-red-400 ring-2 ring-red-300 @enderror">

                <span id="togglePasswordConfirm"
                    class="absolute right-4 top-3 text-slate-500 cursor-pointer hover:text-cyan-600 transition">
                </span>
            </div>

            @error('password_confirmation')
            <p class="text-xs text-red-500 ml-1">
                {{ $message }}
            </p>
            @enderror


            <p class="text-xs text-gray-400 ml-1">
                Password minimal 8 karakter, wajib huruf besar, huruf kecil, dan angka.
            </p>

            <!-- BUTTON -->
            <div class="flex justify-end gap-3 pt-4">

                <button
                    id="closePasswordModal"
                    type="button"
                    class="px-5 py-2 rounded-lg text-gray-600 hover:bg-gray-100 transition">
                    Batal
                </button>

                <button
                    type="submit"
                    class="px-6 py-2 rounded-lg bg-cyan-500 text-white hover:bg-cyan-600 transition">
                    Simpan
                </button>

            </div>

        </form>

    </div>
</div>

@endsection

