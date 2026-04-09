@forelse($data as $index => $item)
<tr class="border-b border-slate-100 hover:bg-slate-50 transition">

    <!-- NO -->
    <td class="px-5 py-4 text-slate-600">
        {{ ($data->currentPage() - 1) * $data->perPage() + $index + 1 }}
    </td>

    <!-- ANGGOTA -->
    <td class="px-5 py-4">
        <div class="font-medium text-slate-800">
            {{ $item->anggota->user->nama ?? $item->anggota->nama_lengkap ?? '-' }}
        </div>
    </td>

    <!-- BUKU -->
    <td class="px-5 py-4">
        <div class="flex items-center gap-3">

            <div class="w-12 h-16 bg-slate-100 rounded-lg overflow-hidden border">
                @if($item->buku->cover)
                    <img src="{{ asset('storage/' . $item->buku->cover) }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-xs text-slate-400">
                        No Img
                    </div>
                @endif
            </div>

            <div>
                <div class="font-medium text-slate-800">
                    {{ $item->buku->judul ?? '-' }}
                </div>
                <div class="text-xs text-slate-500">
                    {{ $item->buku->kode_buku ?? '-' }}
                </div>
            </div>

        </div>
    </td>

    <!-- POSISI -->
    <td class="px-5 py-4">
        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
            {{ $item->posisi_antrian }}
        </span>
    </td>

    <!-- TANGGAL -->
    <td class="px-5 py-4 text-slate-600">
        {{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}
    </td>

    <!-- STATUS -->
    <td class="px-5 py-4">
        @if($item->status === 'menunggu')
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700 border border-yellow-100">
                <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                Menunggu
            </span>
        @elseif($item->status === 'diproses')
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-600 border border-blue-100">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                Diproses
            </span>
        @elseif($item->status === 'selesai')
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600 border border-emerald-100">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                Selesai
            </span>
        @elseif($item->status === 'dibatalkan')
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-600 border border-red-100">
                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                Dibatalkan
            </span>
        @endif
    </td>

    <!-- AKSI -->
    <td class="px-5 py-4 text-center">
        <div class="relative inline-block">

            <!-- BUTTON -->
            <button type="button"
                class="bookActionBtn w-10 h-10 rounded-xl flex items-center justify-center hover:bg-slate-100 transition text-slate-700 text-2xl leading-none">
                ⋯
            </button>

            <!-- DROPDOWN -->
            <div class="bookActionDropdown absolute right-full top-1/2 -translate-y-1/2 mr-3 w-52 bg-white rounded-2xl shadow-xl border border-slate-200 p-2 z-50
                origin-right scale-95 opacity-0 translate-x-2 pointer-events-none transition-all duration-300">

                <!-- DETAIL -->
                <a href="{{ route('petugas.antrian.show', $item->id) }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-slate-700 hover:bg-slate-50 transition">
                    Detail Antrian
                </a>

                @if($item->status === 'selesai')
                    <button 
                        type="button"
                        class="ajaxAction w-full text-left px-4 py-3 rounded-xl text-sm text-red-600 hover:bg-red-50 transition"
                        data-url="{{ route('petugas.antrian.destroy', $item->id) }}"
                        data-method="DELETE"
                        data-confirm="Hapus data antrian ini?"
                    >
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
        Tidak ada data antrian peminjaman.
    </td>
</tr>
@endforelse