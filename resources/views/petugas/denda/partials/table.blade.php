@forelse($data as $index => $item)
<tr class="border-b border-slate-100 hover:bg-slate-50 transition">

    <!-- NO -->
    <td class="px-5 py-4 text-slate-600">
        {{ ($data->currentPage() - 1) * $data->perPage() + $index + 1 }}
    </td>

    <!-- ANGGOTA -->
    <td class="px-5 py-4">
        <div class="font-medium text-slate-800">
            {{ $item->peminjaman->anggota->user->nama ?? '-' }}
        </div>
    </td>

    <!-- BUKU -->
    <td class="px-5 py-4">
        <div class="flex items-center gap-3">

            <div class="w-12 h-16 bg-slate-100 rounded-lg overflow-hidden border">
                @if($item->peminjaman->buku->cover)
                    <img src="{{ asset('storage/' . $item->peminjaman->buku->cover) }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-xs text-slate-400">
                        No Img
                    </div>
                @endif
            </div>

            <div>
                <div class="font-medium text-slate-800">
                    {{ $item->peminjaman->buku->judul ?? '-' }}
                </div>
                <div class="text-xs text-slate-500">
                    {{ $item->peminjaman->buku->kode_buku ?? '-' }}
                </div>
            </div>

        </div>
    </td>

    <!-- HARI TERLAMBAT -->
    <td class="px-5 py-4 text-slate-600">
        {{ $item->hari_terlambat }} Hari
    </td>

    <!-- JUMLAH DENDA -->
    <td class="px-5 py-4">
        <span class="font-semibold text-red-500">
            Rp {{ number_format($item->jumlah_denda, 0, ',', '.') }}
        </span>
    </td>

    <!-- STATUS -->
    <td class="px-5 py-4">
        @if($item->status_denda === 'belum_bayar')
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700 border border-yellow-100">
                <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                Belum Bayar
            </span>
        @elseif($item->status_denda === 'menunggu_verifikasi')
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                Menunggu Verifikasi
            </span>
        @elseif($item->status_denda === 'lunas')
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600 border border-emerald-100">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                Lunas
            </span>
        @elseif($item->status_denda === 'ditolak')
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-100">
                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                Ditolak
            </span>
        @endif
    </td>

    <!-- AKSI -->
    <td class="px-5 py-4 text-center">
        <div class="relative inline-block">

            <!-- BUTTON -->
            <button type="button"
                class="bookActionBtn w-10 h-10 rounded-xl flex items-center justify-center hover:bg-slate-100 transition text-slate-700 text-2xl leading-none"
                aria-label="Menu aksi">
                ⋯
            </button>

            <!-- DROPDOWN -->
            <div class="bookActionDropdown absolute right-full top-1/2 -translate-y-1/2 mr-3 w-60 bg-white rounded-2xl shadow-xl border border-slate-200 p-2 z-50
                origin-right scale-95 opacity-0 translate-x-2 pointer-events-none transition-all duration-300">

                <!-- DETAIL -->
                <a href="{{ route('petugas.denda.show', $item->id) }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-slate-700 hover:bg-slate-50 transition">
                    Detail Denda
                </a>

                @if($item->status_denda === 'menunggu_verifikasi')

                    <!-- VERIFIKASI -->
                    <button type="button"
                        class="ajaxAction w-full text-left px-4 py-3 rounded-xl text-sm text-cyan-700 hover:bg-cyan-50 transition"
                        data-url="{{ route('petugas.denda.verifikasi', $item->id) }}"
                        data-method="POST"
                        data-confirm="Verifikasi pembayaran denda ini sebagai LUNAS?">
                        Verifikasi Pembayaran
                    </button>

                    <!-- TOLAK -->
                    <button type="button"
                        class="ajaxSimpleAction w-full text-left px-4 py-3 rounded-xl text-sm text-amber-700 hover:bg-amber-50 transition"
                        data-url="{{ route('petugas.denda.tolak', $item->id) }}"
                        data-method="POST"
                        data-confirm="Tolak bukti pembayaran ini?"
                        data-prompt="Masukkan alasan penolakan">
                        Tolak Pembayaran
                    </button>

                @elseif($item->status_denda === 'belum_bayar')
                    <div class="px-4 py-3 rounded-xl text-sm text-slate-400 cursor-default">
                        Menunggu pembayaran
                    </div>
                @endif

                @if(in_array($item->status_denda, ['lunas', 'ditolak']))
                    <button type="button"
                        class="ajaxAction w-full text-left px-4 py-3 rounded-xl text-sm text-red-600 hover:bg-red-50 transition"
                        data-url="{{ route('petugas.denda.destroy', $item->id) }}"
                        data-method="DELETE"
                        data-confirm="Yakin ingin menghapus data denda ini?">
                        Hapus Data
                    </button>
                @endif
            </div>
        </div>
    </td>

</tr>
@empty
<tr>
    <td colspan="7" class="px-5 py-12 text-center text-slate-400">
        Tidak ada data denda ditemukan.
    </td>
</tr>
@endforelse