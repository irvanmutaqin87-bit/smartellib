@forelse($data as $index => $buku)
<tr class="border-b border-slate-100 hover:bg-slate-50 transition">
    <td class="px-5 py-4 text-slate-600">
        {{ ($data->currentPage() - 1) * $data->perPage() + $index + 1 }}
    </td>

    <td class="px-5 py-4 font-medium text-slate-800">
        {{ $buku->judul }}
    </td>

    <td class="px-5 py-4 text-slate-600">
        {{ $buku->penulis }}
    </td>

    <td class="px-5 py-4 text-slate-600">
        {{ $buku->kategori->nama_kategori ?? '-' }}
    </td>

    <td class="px-5 py-4 text-slate-600">
        {{ $buku->stok }}
    </td>

    <td class="px-5 py-4">
        @if($buku->stok > 0)
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600 border border-emerald-100">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                Tersedia
            </span>
        @else
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-600 border border-red-100">
                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                Habis
            </span>
        @endif
    </td>

    <td class="px-5 py-4 text-center">
        <div class="relative inline-block">
            <button type="button"
                class="bookActionBtn w-10 h-10 rounded-xl flex items-center justify-center hover:bg-slate-100 transition"
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

            <div class="bookActionDropdown absolute right-full top-1/2 -translate-y-1/2 mr-3 w-52 bg-white rounded-2xl shadow-xl border border-slate-200 p-2 z-50
                origin-right scale-95 opacity-0 translate-x-2 pointer-events-none
                transition-all duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)]">

                <a href="{{ route('petugas.buku.show', $buku->id) }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-slate-700 hover:bg-slate-50 transition">
                    Detail Buku
                </a>

                <a href="{{ route('petugas.buku.edit', $buku->id) }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-slate-700 hover:bg-slate-50 transition">
                    Edit Buku
                </a>

                <button type="button"
                    class="ajaxAction w-full text-left flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-red-600 hover:bg-red-50 transition"
                    data-url="{{ route('petugas.buku.delete', $buku->id) }}"
                    data-confirm="Hapus buku ini?">
                    Hapus Buku
                </button>
            </div>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="px-5 py-10 text-center text-slate-400">
        Tidak ada data buku ditemukan.
    </td>
</tr>
@endforelse
