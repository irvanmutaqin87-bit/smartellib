@forelse($data as $index => $item)
<tr class="border-b border-slate-100 hover:bg-slate-50 transition">
    <td class="px-5 py-4 text-slate-600">
        {{ ($data->currentPage() - 1) * $data->perPage() + $index + 1 }}
    </td>

    <td class="px-5 py-4">
        <div class="font-medium text-slate-800">
            {{ $item->peminjaman->anggota->nama_lengkap ?? '-' }}
        </div>
        <div class="text-xs text-slate-500 mt-1">
            NIS: {{ $item->peminjaman->anggota->nis ?? '-' }}
        </div>
    </td>

    <td class="px-5 py-4">
        <div class="font-medium text-slate-800">
            {{ $item->peminjaman->buku->judul ?? '-' }}
        </div>
        <div class="text-xs text-slate-500 mt-1">
            {{ $item->peminjaman->buku->kode_buku ?? '-' }}
        </div>
    </td>

    <td class="px-5 py-4 text-slate-600">
        {{ $item->hari_terlambat }} Hari
    </td>

    <td class="px-5 py-4">
        <span class="font-semibold text-red-500">
            Rp {{ number_format($item->jumlah_denda, 0, ',', '.') }}
        </span>
    </td>

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

    <td class="px-5 py-4 text-center">
        <div class="relative inline-block">
            <button type="button"
                class="dendaActionBtn w-10 h-10 rounded-xl flex items-center justify-center hover:bg-slate-100 transition"
                aria-label="Menu aksi">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 text-slate-500"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">
                    <circle cx="6" cy="12" r="1.2" fill="currentColor" stroke="none"/>
                    <circle cx="12" cy="12" r="1.2" fill="currentColor" stroke="none"/>
                    <circle cx="18" cy="12" r="1.2" fill="currentColor" stroke="none"/>
                </svg>
            </button>

            <div class="bookActionDropdown absolute right-full top-1/2 -translate-y-1/2 mr-3 w-56 bg-white rounded-2xl shadow-xl border border-slate-200 p-2 z-50
                origin-right scale-95 opacity-0 translate-x-2 pointer-events-none
                transition-all duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)]">

                @if($item->status_denda === 'menunggu_verifikasi')
                    <a href="{{ route('petugas.denda.verifikasi.form', $item->id) }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-cyan-700 hover:bg-cyan-50 transition">
                        Verifikasi Pembayaran
                    </a>
                @elseif($item->status_denda === 'belum_bayar')
                    <div class="px-4 py-3 rounded-xl text-sm text-slate-400 cursor-default">
                        Menunggu pembayaran
                    </div>
                @elseif($item->status_denda === 'lunas')
                    <div class="px-4 py-3 rounded-xl text-sm text-emerald-600 cursor-default">
                        Sudah lunas
                    </div>
                @elseif($item->status_denda === 'ditolak')
                    <div class="px-4 py-3 rounded-xl text-sm text-red-600 cursor-default">
                        Upload ulang bukti
                    </div>
                @endif

                <button type="button"
                    class="ajaxAction w-full text-left flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-red-600 hover:bg-red-50 transition"
                    data-url="{{ route('petugas.denda.destroy', $item->id) }}"
                    data-method="DELETE"
                    data-confirm="Yakin ingin menghapus data denda ini?">
                    Hapus Data
                </button>
            </div>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="px-5 py-10 text-center text-slate-400">
        Tidak ada data denda ditemukan.
    </td>
</tr>
@endforelse