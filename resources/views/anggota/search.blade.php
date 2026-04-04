@extends('layouts.app')

@section('title','Search Buku')

@section('content')

<section class="min-h-screen bg-gray-50 py-10">

    <div class="max-w-7xl mx-auto px-6">

        <!-- ================= HEADER ================= -->
        <div class="flex items-center gap-4 mb-10">

            <!-- BACK (Heroicons) -->
            <button onclick="goBack()"
                class="p-2 rounded-full hover:bg-gray-200 transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6 text-cyan-600"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19l-7-7 7-7" />
                </svg>

            </button>

            <!-- INPUT SEARCH -->
            <div class="relative w-full">

                <input
                    id="searchInput"
                    type="text"
                    placeholder="Cari buku di Smartellib..."
                    class="
                        w-full
                        px-6 py-3 pr-12
                        rounded-full
                        border
                        bg-white
                        shadow-sm
                        text-sm
                        focus:outline-none
                        focus:ring-2
                        focus:ring-cyan-400
                        transition
                    "
                    autofocus
                >

                <!-- ICON SEARCH -->
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    id="searchBtn">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M21 21l-4.35-4.35m1.85-5.65
                        a7.5 7.5 0 11-15 0
                        7.5 7.5 0 0115 0z"/>
                </svg>

            </div>

        </div>

        <!-- ================= RESULT ================= -->
        <div id="resultContainer"
            class="
                grid
                grid-cols-2
                sm:grid-cols-3
                md:grid-cols-5
                gap-10
            ">
        </div>

        <!-- ================= LOADING ================= -->
        <div id="loadingSpinner"
            class="hidden justify-center items-center py-10">

            <div class="w-8 h-8 border-4 border-cyan-400 border-t-transparent rounded-full animate-spin"></div>

        </div>

        <!-- ================= EMPTY ================= -->
        <p id="emptyText"
            class="text-center text-gray-400 mt-10 hidden">
            Buku tidak ditemukan
        </p>

    </div>

</section>

<!-- ================= ROUTE KE JS ================= -->
<script>
    window.searchUrl = "{{ route('search.query') }}";
</script>

@endsection