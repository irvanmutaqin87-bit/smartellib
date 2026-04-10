<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SMARTELLIB')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    @vite(['resources/css/app.css','resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="bg-white overflow-x-hidden">

    {{-- HEADER --}}
    @include('layouts.navbar')

    {{-- CONTENT HALAMAN --}}
    @yield('content')

    {{-- FOOTER --}}
    @include('layouts.footer')

</body>

</html>