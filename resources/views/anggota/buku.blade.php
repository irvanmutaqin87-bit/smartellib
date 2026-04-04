@extends('layouts.app')

@section('title','Buku - SMARTELLIB')

@section('content')

<section class="max-w-5xl mx-auto px-4 py-6">

    <!-- HEADER FILTER -->
    <div class="flex items-center justify-center gap-10 text-gray-600 text-base mb-4">

        <div onclick="toggleFilter()" class="flex items-center gap-2 cursor-pointer">
            <span>Kategori</span>
            <svg id="icon1" class="w-4 h-4 transition-transform duration-300"
                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19 9l-7 7-7-7"/>
            </svg>
        </div>

        <div class="h-5 w-px bg-gray-300"></div>

        <div onclick="toggleFilter()" class="flex items-center gap-2 cursor-pointer">
            <span>Pengarang</span>
            <svg id="icon2" class="w-4 h-4 transition-transform duration-300"
                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19 9l-7 7-7-7"/>
            </svg>
        </div>

        <div class="h-5 w-px bg-gray-300"></div>

        <div onclick="toggleFilter()" class="flex items-center gap-2 cursor-pointer">
            <span>Tahun Terbit</span>
            <svg id="icon3" class="w-4 h-4 transition-transform duration-300"
                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19 9l-7 7-7-7"/>
            </svg>
        </div>

    </div>



    <!-- FILTER BOX -->
    <div id="filterBox"
        class="max-h-0 opacity-0 overflow-hidden
        transition-all duration-500 ease-in-out
        bg-white rounded-xl shadow-xl border">

        <div class="p-6">

            <!-- GRID FILTER -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">


                <!-- ================= KATEGORI ================= -->

                <div>

                    <!-- SEARCH -->
                    <div class="relative mb-3">

                        <input type="text"
                            placeholder="Cari kategori..."
                            onkeyup="filterSearch(this,'kategori-item')"
                            class="w-full border rounded-lg pl-3 pr-9 py-2
                            focus:ring-2 focus:ring-cyan-400 outline-none">

                        <!-- ICON -->
                        <svg class="absolute right-3 top-2.5 w-4 h-4 text-gray-400"
                            fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.3-4.3m1.8-5.2a7 7 0 11-14 0 7 7 0 0114 0z"/>

                        </svg>

                    </div>


                    <div class="h-44 overflow-y-auto border rounded-lg divide-y">

                        <label class="kategori-item flex items-center gap-2 p-3 hover:bg-gray-50">
                            <input type="checkbox" class="accent-cyan-500"> Novel
                        </label>

                        <label class="kategori-item flex items-center gap-2 p-3 hover:bg-gray-50">
                            <input type="checkbox" class="accent-cyan-500"> Edukasi
                        </label>

                        <label class="kategori-item flex items-center gap-2 p-3 hover:bg-gray-50">
                            <input type="checkbox" class="accent-cyan-500"> Teknologi
                        </label>

                        <label class="kategori-item flex items-center gap-2 p-3 hover:bg-gray-50">
                            <input type="checkbox" class="accent-cyan-500"> Filsafat
                        </label>

                        <label class="kategori-item flex items-center gap-2 p-3 hover:bg-gray-50">
                            <input type="checkbox" class="accent-cyan-500"> Manga
                        </label>

                    </div>

                    <button onclick="loadMore('kategori-item',this)"
                        class="w-full mt-2 border rounded-lg py-2 text-sm
                        text-cyan-600 hover:bg-cyan-50">
                        Load More
                    </button>

                </div>



                <!-- ================= PENGARANG ================= -->

                <div>

                    <div class="relative mb-3">

                        <input type="text"
                            placeholder="Cari pengarang..."
                            onkeyup="filterSearch(this,'author-item')"
                            class="w-full border rounded-lg pl-3 pr-9 py-2
                            focus:ring-2 focus:ring-cyan-400 outline-none">

                        <svg class="absolute right-3 top-2.5 w-4 h-4 text-gray-400"
                            fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.3-4.3m1.8-5.2a7 7 0 11-14 0 7 7 0 0114 0z"/>

                        </svg>

                    </div>


                    <div class="h-44 overflow-y-auto border rounded-lg divide-y">

                        <label class="author-item flex items-center gap-2 p-3 hover:bg-gray-50">
                            <input type="checkbox" class="accent-cyan-500"> Henry Manampiring
                        </label>

                        <label class="author-item flex items-center gap-2 p-3 hover:bg-gray-50">
                            <input type="checkbox" class="accent-cyan-500"> Leila S. Chudori
                        </label>

                        <label class="author-item flex items-center gap-2 p-3 hover:bg-gray-50">
                            <input type="checkbox" class="accent-cyan-500"> Keigo Higashino
                        </label>

                        <label class="author-item flex items-center gap-2 p-3 hover:bg-gray-50">
                            <input type="checkbox" class="accent-cyan-500"> Ichiro Kishimi
                        </label>

                    </div>

                    <button onclick="loadMore('author-item',this)"
                        class="w-full mt-2 border rounded-lg py-2 text-sm
                        text-cyan-600 hover:bg-cyan-50">
                        Load More
                    </button>

                </div>



                <!-- ================= TAHUN ================= -->

                <div>

                    <div class="relative mb-3">

                        <input type="text"
                            placeholder="Cari tahun..."
                            onkeyup="filterSearch(this,'year-item')"
                            class="w-full border rounded-lg pl-3 pr-9 py-2
                            focus:ring-2 focus:ring-cyan-400 outline-none">

                        <svg class="absolute right-3 top-2.5 w-4 h-4 text-gray-400"
                            fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.3-4.3m1.8-5.2a7 7 0 11-14 0 7 7 0 0114 0z"/>

                        </svg>

                    </div>


                    <div class="h-44 overflow-y-auto border rounded-lg divide-y">

                        <label class="year-item flex items-center gap-2 p-3 hover:bg-gray-50">
                            <input type="checkbox" class="accent-cyan-500"> 2024
                        </label>

                        <label class="year-item flex items-center gap-2 p-3 hover:bg-gray-50">
                            <input type="checkbox" class="accent-cyan-500"> 2023
                        </label>

                        <label class="year-item flex items-center gap-2 p-3 hover:bg-gray-50">
                            <input type="checkbox" class="accent-cyan-500"> 2022
                        </label>

                        <label class="year-item flex items-center gap-2 p-3 hover:bg-gray-50">
                            <input type="checkbox" class="accent-cyan-500"> 2021
                        </label>

                    </div>

                    <button onclick="loadMore('year-item',this)"
                        class="w-full mt-2 border rounded-lg py-2 text-sm
                        text-cyan-600 hover:bg-cyan-50">
                        Load More
                    </button>

                </div>

            </div>

            <div class="mt-8 pt-6 border-t flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3">

                        <p class="text-sm font-semibold text-gray-700">
                            Tampilkan koleksi yang tersedia :
                        </p>
                        <label class="relative inline-flex items-center cursor-pointer">

                            <input type="checkbox" class="sr-only peer">

                            <div
                                class="w-11 h-6 bg-gray-200 rounded-full
                                peer-checked:bg-cyan-500
                                after:content-['']
                                after:absolute after:top-[2px]
                                after:left-[2px]
                                after:bg-white after:rounded-full
                                after:h-5 after:w-5
                                after:transition-all
                                peer-checked:after:translate-x-full">
                            </div>
                        </label>
                    </div>

                    <p class="text-xs text-gray-500 mt-2 max-w-md">
                        Filter ini akan menampilkan buku yang sedang tidak dipinjam.
                    </p>
                </div>

                <!-- KANAN -->
                <div class="flex items-center gap-4">
                    <button
                        class="text-sm text-gray-500 hover:text-gray-700">
                        Bersihkan Filter
                    </button>
                    <button
                        class="bg-cyan-500 hover:bg-cyan-600
                        text-white text-sm px-8 py-2 rounded-full shadow">
                        OK
                    </button>

                </div>
            </div>
        </div>
    </div>
</section>


<section class="max-w-7xl mx-auto px-24 py-16">

    <div class="flex items-center justify-between mb-10">
        <h2 class="text-lg font-medium text-gray-700 tracking-wide">
            Daftar Buku
        </h2>
    </div>

    <!-- GRID BUKU -->
    <div
        id="bookContainer"
        class="
            grid
            grid-cols-2
            sm:grid-cols-3
            md:grid-cols-5
            gap-10
        "
    >
        
        <a href="" 
        class="book-card group block cursor-pointer opacity-0 translate-y-6 transition-all duration-500 transform-gpu active:scale-95">

            <div
                class="
                relative
                overflow-hidden
                rounded-xl
                shadow-[0_6px_18px_rgba(0,0,0,0.08)]
                transition-all
                duration-500
                group-hover:-translate-y-3
                group-hover:shadow-[0_20px_45px_rgba(0,0,0,0.20)]
                ">

                <div
                    class="
                    absolute
                    inset-0
                    bg-gradient-to-t
                    from-black/10
                    via-transparent
                    to-transparent
                    opacity-0
                    group-hover:opacity-100
                    transition
                    ">
                </div>

                <img
                    src="https://covers.openlibrary.org/b/isbn/9780062316097-L.jpg"
                    class="
                    w-full
                    aspect-[2/3]
                    object-cover
                    brightness-110
                    contrast-110
                    transition
                    duration-500
                    group-hover:scale-105
                    "
                />

            </div>

            <h3 class="mt-3 text-sm font-semibold text-gray-800">
                Sapiens
            </h3>

            <p class="text-xs text-gray-500">
                Yuval Noah Harari
            </p>

        </a>

        <div class="book-card group cursor-pointer opacity-0 translate-y-6 transition-all duration-500">

            <div
                class="
                    relative
                    overflow-hidden
                    rounded-xl
                    shadow-[0_6px_18px_rgba(0,0,0,0.08)]
                    transition-all
                    duration-500
                    group-hover:-translate-y-3
                    group-hover:shadow-[0_20px_45px_rgba(0,0,0,0.20)]
                "
            >

                <div
                    class="
                        absolute
                        inset-0
                        bg-gradient-to-t
                        from-black/10
                        via-transparent
                        to-transparent
                        opacity-0
                        group-hover:opacity-100
                        transition
                    "
                ></div>

                <img
                    src="https://covers.openlibrary.org/b/isbn/9780062316097-L.jpg"
                    class="
                        w-full
                        aspect-[2/3]
                        object-cover
                        brightness-110
                        contrast-110
                        transition
                        duration-500
                        group-hover:scale-105
                    "
                />

            </div>

            <h3 class="mt-3 text-sm font-semibold text-gray-800">
                Sapiens
            </h3>

            <p class="text-xs text-gray-500">
                Yuval Noah Harari
            </p>

        </div>

                <div class="book-card group cursor-pointer opacity-0 translate-y-6 transition-all duration-500 transform-gpu">

            <div
                class="
                    relative
                    overflow-hidden
                    rounded-xl
                    shadow-[0_6px_18px_rgba(0,0,0,0.08)]
                    transition-all
                    duration-500
                    group-hover:-translate-y-3
                    group-hover:shadow-[0_20px_45px_rgba(0,0,0,0.20)]
                "
            >

                <div
                    class="
                        absolute
                        inset-0
                        bg-gradient-to-t
                        from-black/10
                        via-transparent
                        to-transparent
                        opacity-0
                        group-hover:opacity-100
                        transition
                    "
                ></div>

                <img
                    src="https://covers.openlibrary.org/b/isbn/9780062316097-L.jpg"
                    class="
                        w-full
                        aspect-[2/3]
                        object-cover
                        brightness-110
                        contrast-110
                        transition
                        duration-500
                        group-hover:scale-105
                    "
                />

            </div>

            <h3 class="mt-3 text-sm font-semibold text-gray-800">
                Sapiens
            </h3>

            <p class="text-xs text-gray-500">
                Yuval Noah Harari
            </p>

        </div>

                <div class="book-card group cursor-pointer opacity-0 translate-y-6 transition-all duration-500">

            <div
                class="
                    relative
                    overflow-hidden
                    rounded-xl
                    shadow-[0_6px_18px_rgba(0,0,0,0.08)]
                    transition-all
                    duration-500
                    group-hover:-translate-y-3
                    group-hover:shadow-[0_20px_45px_rgba(0,0,0,0.20)]
                "
            >

                <div
                    class="
                        absolute
                        inset-0
                        bg-gradient-to-t
                        from-black/10
                        via-transparent
                        to-transparent
                        opacity-0
                        group-hover:opacity-100
                        transition
                    "
                ></div>

                <img
                    src="https://covers.openlibrary.org/b/isbn/9780062316097-L.jpg"
                    class="
                        w-full
                        aspect-[2/3]
                        object-cover
                        brightness-110
                        contrast-110
                        transition
                        duration-500
                        group-hover:scale-105
                    "
                />

            </div>

            <h3 class="mt-3 text-sm font-semibold text-gray-800">
                Sapiens
            </h3>

            <p class="text-xs text-gray-500">
                Yuval Noah Harari
            </p>

        </div>

                <div class="book-card group cursor-pointer opacity-0 translate-y-6 transition-all duration-500">

            <div
                class="
                    relative
                    overflow-hidden
                    rounded-xl
                    shadow-[0_6px_18px_rgba(0,0,0,0.08)]
                    transition-all
                    duration-500
                    group-hover:-translate-y-3
                    group-hover:shadow-[0_20px_45px_rgba(0,0,0,0.20)]
                "
            >

                <div
                    class="
                        absolute
                        inset-0
                        bg-gradient-to-t
                        from-black/10
                        via-transparent
                        to-transparent
                        opacity-0
                        group-hover:opacity-100
                        transition
                    "
                ></div>

                <img
                    src="https://covers.openlibrary.org/b/isbn/9780062316097-L.jpg"
                    class="
                        w-full
                        aspect-[2/3]
                        object-cover
                        brightness-110
                        contrast-110
                        transition
                        duration-500
                        group-hover:scale-105
                    "
                />

            </div>

            <h3 class="mt-3 text-sm font-semibold text-gray-800">
                Sapiens
            </h3>

            <p class="text-xs text-gray-500">
                Yuval Noah Harari
            </p>

        </div>


    </div>

    <div class="flex justify-center mt-14">

        <button
            id="loadMoreBtn"
            onclick="loadMoreBooks()"
            class="
            flex items-center gap-2 hover:gap-3
            px-10
            py-3
            text-sm
            rounded-full
            bg-cyan-500
            hover:bg-cyan-600
            text-white
            shadow-md
            transition
            duration-300
            ">

            <!-- ICON -->
            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-4 h-4">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />

            </svg>

            Selengkapnya

        </button>

    </div>

</section>

@endsection