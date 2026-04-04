<header class="sticky top-0 z-50 backdrop-blur-md
    bg-gradient-to-r from-cyan-100/70 via-cyan-100/40 to-cyan-100/70
    border-b">

    <div class="max-w-7xl mx-auto px-20 py-4 flex items-center justify-between">

        <img
            src="{{ asset('img/logo.png') }}"
            class="w-44 object-contain drop-shadow-2xl hover:opacity-90 transition"
        />

        <div class="relative group">
            <input
                onclick="goToSearch()"
                readonly
                placeholder="Cari buku di Smartellib..."
                class="cursor-pointer w-[380px] focus:w-[460px]
                transition-all duration-300 ease-in-out
                bg-white/80 backdrop-blur
                rounded-full px-5 py-2.5 text-sm
                shadow-sm border
                focus:outline-none
                focus:ring-2 focus:ring-cyan-400"
            />

            <svg
                class="w-5 h-5 absolute right-4 top-2.5 text-gray-500"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M21 21l-4.35-4.35m1.85-5.65
                    a7.5 7.5 0 11-15 0
                    7.5 7.5 0 0115 0z"
                />
            </svg>
        </div>

        <div class="flex items-center gap-10">
            <nav id="navMenu" class="relative flex items-center gap-8">
                <a
                    href="{{ route('anggota.beranda') }}"
                    class="nav-link text-cyan-600 hover:text-cyan-500 transition-colors
                    {{ request()->routeIs('anggota.beranda') ? 'active font-semibold text-cyan-500' : '' }}"
                >
                    Beranda
                </a>

                <a
                    href="{{ route('anggota.buku.index') }}"
                    class="nav-link text-cyan-600 hover:text-cyan-500 transition-colors
                    {{ request()->routeIs('anggota.buku.index') ? 'active font-semibold text-cyan-500' : '' }}"
                >
                    Buku
                </a>

                <!-- SLIDING UNDERLINE -->
                <span
                    id="navIndicator"
                    class="absolute -bottom-1
                    h-[2px]
                    bg-cyan-500
                    rounded-full
                    transition-all duration-300 ease-in-out"
                ></span>
            </nav>

            <div class="relative">

                <button
                    id="profileBtn"
                    class="w-9 h-9 rounded-full
                    bg-gradient-to-br from-cyan-500 to-cyan-500
                    text-white font-semibold text-sm
                    flex items-center justify-center
                    ring-2 ring-cyan-300/40
                    shadow-[0_0_12px_rgba(34,211,238,0.45)]
                    hover:scale-105
                    hover:shadow-[0_0_18px_rgba(34,211,238,0.65)]
                    transition duration-300"
                >
                    IM
                </button>

                <!-- PROFILE DROPDOWN -->
                <div
                    id="profileDropdown"
                        class="absolute right-0 mt-4 w-[350px]
                        bg-white rounded-2xl shadow-xl border p-3
                        origin-top transform scale-y-0 opacity-0 -translate-y-2
                        transition-all duration-300 ease-out">

                    <!-- PROFILE CARD -->
                    <div
                        class="bg-gradient-to-r from-cyan-500 to-cyan-400
                        rounded-b-2xl p-5 text-white
                        flex items-center gap-4">

                        <!-- AVATAR -->
                        <div class="relative">

                            <div
                                class="w-16 h-16 rounded-full
                                bg-gradient-to-br from-cyan-400 to-cyan-500
                                flex items-center justify-center
                                text-xl font-semibold">
                                IM
                            </div>

                            <!-- SETTINGS ICON -->
                            <a href="{{ route('anggota.data_profile') }}">
                            <div
                                class="absolute -bottom-1 -right-1
                                w-7 h-7 bg-white rounded-full
                                flex items-center justify-center
                                shadow">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-4 h-4 text-cyan-600"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M10.325 4.317
                                        c.426-1.756 2.924-1.756
                                        3.35 0a1.724 1.724 0 002.573 1.066
                                        c1.543-.94 3.31.826
                                        2.37 2.37a1.724 1.724 0 001.065 2.572
                                        c1.756.426 1.756 2.924
                                        0 3.35a1.724 1.724 0 00-1.066 2.573
                                        c.94 1.543-.826 3.31
                                        -2.37 2.37a1.724 1.724 0 00-2.572 1.065
                                        c-.426 1.756-2.924 1.756
                                        -3.35 0a1.724 1.724 0 00-2.573-1.066
                                        c-1.543.94-3.31-.826
                                        -2.37-2.37a1.724 1.724 0 00-1.065-2.572
                                        c-1.756-.426-1.756-2.924
                                        0-3.35a1.724 1.724 0 001.066-2.573
                                        c-.94-1.543.826-3.31
                                        2.37-2.37.996.608
                                        2.296.07 2.572-1.065z" />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0
                                        3 3 0 016 0z" />
                                </svg>
                            </div>
                            </a>
                        </div>

                        <div>
                            <div class="font-semibold text-lg leading-tight">
                                {{ auth()->user()->nama ?? 'Irvan Mutaqin' }}
                            </div>

                            <div class="text-xs flex items-center gap-2 opacity-90 mt-1">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>

                                {{ auth()->user()->email ?? 'irvan@email.com' }}
                            </div>

                            <a href="{{ route('anggota.profile') }}"
                            class="inline-block mt-3 bg-white text-cyan-600
                            text-sm font-medium
                            px-4 py-1.5 rounded-full
                            hover:bg-cyan-100 transition">
                                Lihat profil
                            </a>
                        </div>
                    </div>

                    <div class="flex justify-center mt-5">

                        <a
                            href="{{ route('anggota.rak') }}"
                            class="flex flex-col items-center gap-2
                            group">

                            <div
                                class="w-14 h-14 rounded-full
                                bg-cyan-100 flex items-center
                                justify-center transition">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-cyan-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m7.875 14.25 1.214 1.942a2.25 2.25 0 0 0 1.908 1.058h2.006c.776 0 1.497-.4 1.908-1.058l1.214-1.942M2.41 9h4.636a2.25 2.25 0 0 1 1.872 1.002l.164.246a2.25 2.25 0 0 0 1.872 1.002h2.092a2.25 2.25 0 0 0 1.872-1.002l.164-.246A2.25 2.25 0 0 1 16.954 9h4.636M2.41 9a2.25 2.25 0 0 0-.16.832V12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 12V9.832c0-.287-.055-.57-.16-.832M2.41 9a2.25 2.25 0 0 1 .382-.632l3.285-3.832a2.25 2.25 0 0 1 1.708-.786h8.43c.657 0 1.281.287 1.709.786l3.284 3.832c.163.19.291.404.382.632M4.5 20.25h15A2.25 2.25 0 0 0 21.75 18v-2.625c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125V18a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>

                            </div>

                            <span class="text-sm text-cyan-600">
                                Rak Pinjam
                            </span>
                        </a>
                    </div>


                    <div class="border-t mt-5"></div>

                    <div class="flex justify-center mt-4">

                        <form action="{{ route('logout') }}" method="POST" class="inline-block">
                            @csrf

                            <button
                                type="submit"
                                class="flex items-center gap-3
                                bg-cyan-100 hover:bg-cyan-200
                                px-5 py-2.5 rounded-full
                                transition active:scale-95">

                                <div
                                    class="w-8 h-8 rounded-full
                                    bg-cyan-600 text-white
                                    flex items-center justify-center">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="size-4">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />

                                    </svg>
                                </div>

                                <span class="text-sm text-gray-700">
                                    Keluar Dari Aplikasi
                                </span>

                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>