<div id="bookDetailActions" class="flex flex-wrap gap-4 mt-5">

    {{-- 1. PRIORITAS: SEDANG PINJAM --}}
    @if($sedangDipinjamUser)
    <form id="kembalikanForm"
        action="{{ route('anggota.peminjaman.kembalikan', $sedangDipinjamUser->id) }}"
        method="POST">
        @csrf

        {{-- 🔥 WAJIB --}}
        <input type="hidden" name="buku_id" value="{{ $buku->id }}">

        <button type="submit"
            class="px-6 py-2 bg-rose-500 text-white rounded-full hover:bg-rose-600">
            Kembalikan Buku
        </button>
    </form>

    {{-- 2. PRIORITAS: SUDAH ANTRI --}}
    @elseif($sudahAntri)
        <button disabled
            class="px-6 py-2 bg-gray-300 text-white rounded-full cursor-not-allowed">
            Menunggu Antrian
        </button>

    {{-- 3. BLOKIR DENDA --}}
    @elseif($dendaAktif && in_array($dendaAktif->status_denda, ['belum_bayar','menunggu_verifikasi','ditolak']))
        <button disabled
            class="px-6 py-2 bg-gray-300 text-white rounded-full">
            Pinjam Diblokir
        </button>

    {{-- 4. BOLEH PINJAM --}}
    @elseif($bolehPinjam)
    <form id="pinjamForm"
        action="{{ route('anggota.buku.pinjam', $buku->id) }}"
        method="POST">
        @csrf

        {{-- 🔥 WAJIB --}}
        <input type="hidden" name="buku_id" value="{{ $buku->id }}">

        <button type="submit"
            class="px-6 py-2 bg-cyan-400 text-white rounded-full hover:bg-cyan-500">
            {{ $stokHabis ? 'Pinjam (Masuk Antrian)' : 'Pinjam' }}
        </button>
    </form>

    {{-- 5. FALLBACK --}}
    @else
        <div class="text-red-500 text-sm">
            Tidak dapat melakukan peminjaman atau antrian.
        </div>
    @endif

    {{-- BACA --}}
    @if($isDigital && $sedangDipinjamUser)
        <a href="{{ asset('storage/' . $buku->file_buku) }}" target="_blank"
            class="px-6 py-2 bg-cyan-400 text-white rounded-full hover:bg-cyan-500">
            Baca
        </a>
    @endif

    {{-- DOWNLOAD --}}
    @if($isDigital && $sedangDipinjamUser)
        <a href="{{ asset('storage/' . $buku->file_buku) }}" download
            class="px-6 py-2 bg-cyan-400 text-white rounded-full hover:bg-cyan-500">
            Download
        </a>
    @endif

    {{-- ULASAN --}}
    @if($bolehUlasan)
        <button type="button" id="openUlasanModal"
            class="px-6 py-2 bg-cyan-400 text-white rounded-full hover:bg-cyan-500">
            {{ $userComment || $userRating ? 'Edit Ulasan' : 'Berikan Ulasan' }}
        </button>
    @endif

</div>