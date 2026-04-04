@extends('layouts.app')

@section('title','Beranda - SMARTELLIB')

@section('content')

<section class="max-w-6xl mx-auto mt-24">

    <div class="relative flex justify-center items-center">

        <!-- BUTTON LEFT -->
        <button
            onclick="prevSlide()"
            class="absolute left-[15%] z-20
            bg-cyan-200/10
            border border-cyan-400/40
            (6,182,212,0.3)
            p-3 rounded-full
            hover:bg-cyan-200/20
            hover:shadow-rgba(6,182,212,0.6)
            hover:scale-110
            transition duration-300"
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 text-cyan-500"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15.75 19.5L8.25 12l7.5-7.5"
                />
            </svg>

        </button>


        <!-- CAROUSEL -->
        <div class="relative w-[700px] h-[420px] flex items-center justify-center perspective">

            <!-- LEFT BOOK -->
            <div
                id="leftCard"
                class="absolute transition-all duration-700 ease-[cubic-bezier(.22,.61,.36,1)] opacity-60 blur-[1px]"
            >
                <img
                    id="leftImg"
                    class="w-44 aspect-[2/3] object-cover rounded-xl shadow-xl transition"
                >
            </div>


            <!-- CENTER BOOK -->
            <div
                id="centerCard"
                class="absolute z-10 transition-all duration-700 ease-[cubic-bezier(.22,.61,.36,1)]"
            >
                <img
                    id="centerImg"
                    class="w-52 aspect-[2/3] object-cover rounded-xl shadow-2xl transition"
                >

                <h3
                    id="bookTitle"
                    class="text-center mt-4 font-semibold text-sm"
                ></h3>

                <p
                    id="bookAuthor"
                    class="text-center text-xs text-gray-500"
                ></p>
            </div>


            <!-- RIGHT BOOK -->
            <div
                id="rightCard"
                class="absolute transition-all duration-700 ease-[cubic-bezier(.22,.61,.36,1)] opacity-60 blur-[1px]"
            >
                <img
                    id="rightImg"
                    class="w-44 aspect-[2/3] object-cover rounded-xl shadow-xl transition"
                >
            </div>

        </div>


        <!-- BUTTON RIGHT -->
        <button
            onclick="nextSlide()"
            class="absolute right-[15%] z-20
            bg-cyan-200/10
            border border-cyan-200/40
            p-3 rounded-full
            hover:bg-cyan-200/20
            hover:scale-110
            transition duration-300"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 text-cyan-500"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M8.25 4.5l7.5 7.5-7.5 7.5"
                />
            </svg>
        </button>

    </div>

</section>

<style>
    .perspective {
        perspective: 1200px;
    }
</style>

<main class="max-w-7xl mx-auto px-24 py-16">

    <div class="flex items-center justify-between mb-10">
        <h2 class="text-lg font-medium text-gray-700 tracking-wide">
            Rekomendasi Buku
        </h2>
        <a href="#" 
            class="text-cyan-500 text-sm font-medium hover:text-cyan-600 transition">
            Baca Selengkapnya
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-10">

        <div class="group cursor-pointer book-card opacity-0 translate-y-6">
            <div class="relative overflow-hidden rounded-xl shadow-[0_6px_18px_rgba(0,0,0,0.08)] transition-all duration-500 group-hover:-translate-y-3 group-hover:shadow-[0_20px_45px_rgba(0,0,0,0.20)]">
                <div class="absolute inset-0  bg-gradient-to-t  from-black/10 via-transparent to-transpare opacity-0 group-hover:opacity-100transition"></div>
                <img src="https://covers.openlibrary.org/b/isbn/9780062316097-L.jpg"
                        class="w-full aspect-[2/3] object-cover brightness-110 contrast-110 transition duration-500 group-hover:scale-105 group-hover:brightness-115"/>
            </div>
            <h3 class="mt-3 text-sm font-semibold text-gray-800">
                Sapiens
            </h3>
            <p class="text-xs text-gray-500">
                Yuval Noah Harari
            </p>
        </div>

        <div class="group cursor-pointer book-card opacity-0 translate-y-6">
            <div class="relative overflow-hidden rounded-xl shadow-[0_6px_18px_rgba(0,0,0,0.08)] transition-all duration-500 group-hover:-translate-y-3 group-hover:shadow-[0_20px_45px_rgba(0,0,0,0.20)]">
                <div class="absolute inset-0 bg-gradient-to-t from-black/10 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                <img src="https://covers.openlibrary.org/b/isbn/9781847941831-L.jpg"
                        class="w-full aspect-[2/3] object-cover brightness-110 contrast-110 transition duration-500 group-hover:scale-105 group-hover:brightness-115"/>
            </div>
            <h3 class="mt-3 text-sm font-semibold text-gray-800">
                Atomic Habits
            </h3>
            <p class="text-xs text-gray-500">
                James Clear
            </p>

        </div>
    
        <div class="group cursor-pointer book-card opacity-0 translate-y-6">
            <div class="relative overflow-hidden rounded-xl shadow-[0_6px_18px_rgba(0,0,0,0.08)] transition-all duration-500 group-hover:-translate-y-3 group-hover:shadow-[0_20px_45px_rgba(0,0,0,0.20)]">
                <div class="absolute inset-0 bg-gradient-to-t from-black/10 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                <img src="https://covers.openlibrary.org/b/isbn/9780812981605-L.jpg"
                        class="w-full aspect-[2/3] object-cover brightness-110 contrast-110 transition duration-500 group-hover:scale-105 group-hover:brightness-115"/>

            </div>
            <h3 class="mt-3 text-sm font-semibold text-gray-800">
                The Power of Habit
            </h3>
            <p class="text-xs text-gray-500">
                Charles Duhigg
            </p>

        </div>

        <div class="group cursor-pointer book-card opacity-0 translate-y-6">
            <div class="relative overflow-hidden rounded-xl shadow-[0_6px_18px_rgba(0,0,0,0.08)] transition-all duration-500 group-hover:-translate-y-3 group-hover:shadow-[0_20px_45px_rgba(0,0,0,0.20)]">
                <div class="absolute inset-0 bg-gradient-to-t from-black/10 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                <img src="https://covers.openlibrary.org/b/isbn/9781612680194-L.jpg"
                        class="w-full aspect-[2/3] object-cover brightness-110 contrast-110 transition duration-500 group-hover:scale-105 group-hover:brightness-115"/>
            </div>
            <h3 class="mt-3 text-sm font-semibold text-gray-800">
                Rich Dad Poor Dad
            </h3>
            <p class="text-xs text-gray-500">
                Robert T. Kiyosaki
            </p>
        </div>
        <div class="group cursor-pointer book-card opacity-0 translate-y-6">
            <div class="relative overflow-hidden rounded-xl shadow-[0_6px_18px_rgba(0,0,0,0.08)] transition-all duration-500 group-hover:-translate-y-3 group-hover:shadow-[0_20px_45px_rgba(0,0,0,0.20)]">
                <div class="absolute inset-0 bg-gradient-to-t from-black/10 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                <img src="https://covers.openlibrary.org/b/isbn/9781544512280-L.jpg"
                        class="w-full aspect-[2/3] object-cover brightness-110 contrast-110 transition duration-500 group-hover:scale-105 group-hover:brightness-115"/>
            </div>
            <h3 class="mt-3 text-sm font-semibold text-gray-800">
                Can't Hurt Me
            </h3>
            <p class="text-xs text-gray-500">
                David Goggins
            </p>
        </div>

        <div class="group cursor-pointer book-card opacity-0 translate-y-6">
            <div class="relative overflow-hidden rounded-xl shadow-[0_6px_18px_rgba(0,0,0,0.08)] transition-all duration-500 group-hover:-translate-y-3 group-hover:shadow-[0_20px_45px_rgba(0,0,0,0.20)]">
                <img src="https://covers.openlibrary.org/b/isbn/9780061122415-L.jpg"
                      class="w-full aspect-[2/3] object-cover brightness-110 contrast-110 transition duration-500 group-hover:scale-105"/>
            </div>
            <h3 class="mt-3 text-sm font-semibold text-gray-800">The Alchemist</h3>
            <p class="text-xs text-gray-500">Paulo Coelho</p>
        </div>

        <div class="group cursor-pointer book-card opacity-0 translate-y-6">
            <div class="relative overflow-hidden rounded-xl shadow-[0_6px_18px_rgba(0,0,0,0.08)] transition-all duration-500 group-hover:-translate-y-3 group-hover:shadow-[0_20px_45px_rgba(0,0,0,0.20)]">
                <img src="https://covers.openlibrary.org/b/isbn/9780060935467-L.jpg"
                      class="w-full aspect-[2/3] object-cover brightness-110 contrast-110 transition duration-500 group-hover:scale-105"/>
            </div>
            <h3 class="mt-3 text-sm font-semibold text-gray-800">To Kill a Mockingbird</h3>
            <p class="text-xs text-gray-500">Harper Lee</p>
        </div>

        <div class="group cursor-pointer book-card opacity-0 translate-y-6">
            <div class="relative overflow-hidden rounded-xl shadow-[0_6px_18px_rgba(0,0,0,0.08)] transition-all duration-500 group-hover:-translate-y-3 group-hover:shadow-[0_20px_45px_rgba(0,0,0,0.20)]">
                <img src="https://covers.openlibrary.org/b/isbn/9780451524935-L.jpg"
                      class="w-full aspect-[2/3] object-cover brightness-110 contrast-110 transition duration-500 group-hover:scale-105"/>
            </div>
            <h3 class="mt-3 text-sm font-semibold text-gray-800">1984</h3>
            <p class="text-xs text-gray-500">George Orwell</p>
        </div>

        <div class="group cursor-pointer book-card opacity-0 translate-y-6">
            <div class="relative overflow-hidden rounded-xl shadow-[0_6px_18px_rgba(0,0,0,0.08)] transition-all duration-500 group-hover:-translate-y-3 group-hover:shadow-[0_20px_45px_rgba(0,0,0,0.20)]">
                <img src="https://covers.openlibrary.org/b/isbn/9780590353427-L.jpg"
                      class="w-full aspect-[2/3] object-cover brightness-110 contrast-110 transition duration-500 group-hover:scale-105"/>
            </div>
            <h3 class="mt-3 text-sm font-semibold text-gray-800">Harry Potter</h3>
            <p class="text-xs text-gray-500">J.K. Rowling</p>
        </div>


        <div class="group cursor-pointer book-card opacity-0 translate-y-6">
            <div class="relative overflow-hidden rounded-xl shadow-[0_6px_18px_rgba(0,0,0,0.08)] transition-all duration-500 group-hover:-translate-y-3 group-hover:shadow-[0_20px_45px_rgba(0,0,0,0.20)]">
                <img src="https://covers.openlibrary.org/b/isbn/9780743273565-L.jpg"
                      class="w-full aspect-[2/3] object-cover brightness-110 contrast-110 transition duration-500 group-hover:scale-105"/>
            </div>
            <h3 class="mt-3 text-sm font-semibold text-gray-800">The Great Gatsby</h3>
            <p class="text-xs text-gray-500">F. Scott Fitzgerald</p>
        </div>


        <div class="group cursor-pointer book-card opacity-0 translate-y-6">
            <div class="relative overflow-hidden rounded-xl shadow-[0_6px_18px_rgba(0,0,0,0.08)] transition-all duration-500 group-hover:-translate-y-3 group-hover:shadow-[0_20px_45px_rgba(0,0,0,0.20)]">
                <img src="https://covers.openlibrary.org/b/isbn/9780316769488-L.jpg"
                      class="w-full aspect-[2/3] object-cover brightness-110 contrast-110 transition duration-500 group-hover:scale-105"/>
            </div>
            <h3 class="mt-3 text-sm font-semibold text-gray-800">The Catcher in the Rye</h3>
            <p class="text-xs text-gray-500">J.D. Salinger</p>
        </div>


        <div class="group cursor-pointer book-card opacity-0 translate-y-6">
            <div class="relative overflow-hidden rounded-xl shadow-[0_6px_18px_rgba(0,0,0,0.08)] transition-all duration-500 group-hover:-translate-y-3 group-hover:shadow-[0_20px_45px_rgba(0,0,0,0.20)]">
                <img src="https://covers.openlibrary.org/b/isbn/9781451673319-L.jpg"
                      class="w-full aspect-[2/3] object-cover brightness-110 contrast-110 transition duration-500 group-hover:scale-105"/>
            </div>
            <h3 class="mt-3 text-sm font-semibold text-gray-800">Fahrenheit 451</h3>
            <p class="text-xs text-gray-500">Ray Bradbury</p>
        </div>


        <div class="group cursor-pointer book-card opacity-0 translate-y-6">
            <div class="relative overflow-hidden rounded-xl shadow-[0_6px_18px_rgba(0,0,0,0.08)] transition-all duration-500 group-hover:-translate-y-3 group-hover:shadow-[0_20px_45px_rgba(0,0,0,0.20)]">
                <img src="https://covers.openlibrary.org/b/isbn/9780547978840-L.jpg"
                      class="w-full aspect-[2/3] object-cover brightness-110 contrast-110 transition duration-500 group-hover:scale-105"/>
            </div>
            <h3 class="mt-3 text-sm font-semibold text-gray-800">The Little Prince</h3>
            <p class="text-xs text-gray-500">Antoine de Saint-Exupéry</p>
        </div>


        <div class="group cursor-pointer book-card opacity-0 translate-y-6">
            <div class="relative overflow-hidden rounded-xl shadow-[0_6px_18px_rgba(0,0,0,0.08)] transition-all duration-500 group-hover:-translate-y-3 group-hover:shadow-[0_20px_45px_rgba(0,0,0,0.20)]">
                <img src="https://covers.openlibrary.org/b/isbn/9780141033570-L.jpg"
                      class="w-full aspect-[2/3] object-cover brightness-110 contrast-110 transition duration-500 group-hover:scale-105"/>
            </div>
            <h3 class="mt-3 text-sm font-semibold text-gray-800">Thinking Fast and Slow</h3>
            <p class="text-xs text-gray-500">Daniel Kahneman</p>
        </div>


        <div class="group cursor-pointer book-card opacity-0 translate-y-6">
            <div class="relative overflow-hidden rounded-xl shadow-[0_6px_18px_rgba(0,0,0,0.08)] transition-all duration-500 group-hover:-translate-y-3 group-hover:shadow-[0_20px_45px_rgba(0,0,0,0.20)]">
                <img src="https://covers.openlibrary.org/b/isbn/9780307887894-L.jpg"
                      class="w-full aspect-[2/3] object-cover brightness-110 contrast-110 transition duration-500 group-hover:scale-105"/>
            </div>
            <h3 class="mt-3 text-sm font-semibold text-gray-800">The Lean Startup</h3>
            <p class="text-xs text-gray-500">Eric Ries</p>
        </div>
    </div>
</main>

<section class="max-w-6xl mx-auto px-24 py-16">
    <h2 class="text-center text-2xl mb-14">
        Buku Ter Atas
    </h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-x-16 gap-y-20 justify-center">
        <div class="group w-40 text-center cursor-pointer book-card opacity-0 translate-y-6">
            <div class="relative overflow-hidden rounded-lg shadow-md
                        transition duration-500
                        group-hover:shadow-xl
                        group-hover:-translate-y-2">
                <img
                    src="https://covers.openlibrary.org/b/isbn/9780062316097-L.jpg"
                    class="w-full aspect-[2/3] object-cover
                            brightness-105 contrast-105
                            transition duration-500
                            group-hover:scale-105
                            group-hover:brightness-110"
                >
            </div>
            <h3 class="mt-4 text-base font-medium text-gray-800">
                Sapiens
            </h3>
            <p class="text-sm text-gray-500">
                Yuval Noah Harari
            </p>
        </div>

        <div class="group w-40 text-center cursor-pointer book-card opacity-0 translate-y-6">
            <div class="relative overflow-hidden rounded-lg shadow-md
                        transition duration-500
                        group-hover:shadow-xl
                        group-hover:-translate-y-2">
                <img
                    src="https://covers.openlibrary.org/b/isbn/9780735211292-L.jpg"
                    class="w-full aspect-[2/3] object-cover
                            brightness-105 contrast-105
                            transition duration-500
                            group-hover:scale-105
                            group-hover:brightness-110"
                >
            </div>
            <h3 class="mt-4 text-base font-medium text-gray-800">
                Atomic Habits
            </h3>
            <p class="text-sm text-gray-500">
                James Clear
            </p>
        </div>
        <div class="group w-40 text-center cursor-pointer book-card opacity-0 translate-y-6">
            <div class="relative overflow-hidden rounded-lg shadow-md
                        transition duration-500
                        group-hover:shadow-xl
                        group-hover:-translate-y-2">
                <img
                    src="https://covers.openlibrary.org/b/isbn/9780062457714-L.jpg"
                    class="w-full aspect-[2/3] object-cover
                            brightness-105 contrast-105
                            transition duration-500
                            group-hover:scale-105
                            group-hover:brightness-110"
                >
            </div>
            <h3 class="mt-4 text-base font-medium text-gray-800">
                The Subtle Art of Not Giving a F*ck
            </h3>
            <p class="text-sm text-gray-500">
                Mark Manson
            </p>
        </div>

        <div class="group w-40 text-center cursor-pointer book-card opacity-0 translate-y-6">
            <div class="relative overflow-hidden rounded-lg shadow-md
                        transition duration-500
                        group-hover:shadow-xl
                        group-hover:-translate-y-2">
                <img
                    src="https://covers.openlibrary.org/b/isbn/9780451524935-L.jpg"
                    class="w-full aspect-[2/3] object-cover
                            brightness-105 contrast-105
                            transition duration-500
                            group-hover:scale-105
                            group-hover:brightness-110"
                >
            </div>
            <h3 class="mt-4 text-base font-medium text-gray-800">
                1984
            </h3>
            <p class="text-sm text-gray-500">
                George Orwell
            </p>
        </div>

        <div class="col-span-2 md:col-span-4 flex justify-center gap-16">
            <div class="group w-40 text-center cursor-pointer book-card opacity-0 translate-y-6">
                <div class="relative overflow-hidden rounded-lg shadow-md
                            transition duration-500
                            group-hover:shadow-xl
                            group-hover:-translate-y-2">
                    <img
                        src="https://covers.openlibrary.org/b/isbn/9780547928227-L.jpg"
                        class="w-full aspect-[2/3] object-cover
                                brightness-105 contrast-105
                                transition duration-500
                                group-hover:scale-105
                                group-hover:brightness-110"
                    >
                </div>
                <h3 class="mt-4 text-base font-medium text-gray-800">
                    The Hobbit
                </h3>
                <p class="text-sm text-gray-500">
                    J.R.R. Tolkien
                </p>
            </div>

            <!-- 6 -->
            <div class="group w-40 text-center cursor-pointer book-card opacity-0 translate-y-6">
                <div class="relative overflow-hidden rounded-lg shadow-md
                            transition duration-500
                            group-hover:shadow-xl
                            group-hover:-translate-y-2">
                    <img
                        src="https://covers.openlibrary.org/b/isbn/9780141439518-L.jpg"
                        class="w-full aspect-[2/3] object-cover
                                brightness-105 contrast-105
                                transition duration-500
                                group-hover:scale-105
                                group-hover:brightness-110"
                    >
                </div>
                <h3 class="mt-4 text-base font-medium text-gray-800">
                    Pride and Prejudice
                </h3>
                <p class="text-sm text-gray-500">
                    Jane Austen
                </p>
            </div>

            <!-- 7 -->
            <div class="group w-40 text-center cursor-pointer book-card opacity-0 translate-y-6">
                <div class="relative overflow-hidden rounded-lg shadow-md
                            transition duration-500
                            group-hover:shadow-xl
                            group-hover:-translate-y-2">
                    <img
                        src="https://covers.openlibrary.org/b/isbn/9780061122415-L.jpg"
                        class="w-full aspect-[2/3] object-cover
                                brightness-105 contrast-105
                                transition duration-500
                                group-hover:scale-105
                                group-hover:brightness-110"
                    >
                </div>
                <h3 class="mt-4 text-base font-medium text-gray-800">
                    The Alchemist
                </h3>
                <p class="text-sm text-gray-500">
                    Paulo Coelho
                </p>
            </div>
        </div>
    </div>
</section>

@endsection