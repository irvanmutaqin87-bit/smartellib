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
        <a href="{{ route('admin.buku.show', $buku->id) }}"
           class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-sm font-medium text-white bg-cyan-900/80 hover:bg-cyan-800/80 transition">
            Detail Buku
        </a>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="px-5 py-10 text-center text-slate-400">
        Tidak ada data buku ditemukan.
    </td>
</tr>
@endforelse