@extends('layouts.app')

@section('title','Search Buku')

@section('content')

<section class="min-h-screen bg-gray-50 py-10 px-12">

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

<script>
    window.searchUrl = "{{ route('anggota.search.query') }}";
</script>

@endsection