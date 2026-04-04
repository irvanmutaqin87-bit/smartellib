@forelse($data as $index => $item)
<tr class="border-b border-slate-100 hover:bg-slate-50 transition">
    <td class="px-5 py-4 text-slate-600 align-top">
        {{ ($data->currentPage() - 1) * $data->perPage() + $index + 1 }}
    </td>

    <td class="px-5 py-4 align-top">
        <div class="font-medium text-slate-800">
            {{ $item->anggota->nama_lengkap ?? '-' }}
        </div>
        <div class="text-xs text-slate-500 mt-1">
            NIS: {{ $item->anggota->nis ?? '-' }}
        </div>
    </td>

    <td class="px-5 py-4 align-top">
        <div class="font-medium text-slate-800">
            {{ $item->buku->judul ?? '-' }}
        </div>
        <div class="text-xs text-slate-500 mt-1">
            {{ $item->buku->kode_buku ?? '-' }}
        </div>
    </td>

    <td class="px-5 py-4 align-top">
        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
            #{{ $item->posisi_antrian }}
        </span>
    </td>

    <td class="px-5 py-4 align-top">
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

    <td class="px-5 py-4 text-slate-600 align-top">
        {{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}
    </td>

    <td class="px-5 py-4 text-center align-top">
        <div class="flex items-center justify-center gap-2 flex-wrap">

            @if($item->status === 'menunggu')
                <button type="button"
                    class="ajaxAction px-4 py-2 rounded-xl bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium transition shadow-sm"
                    data-url="{{ route('petugas.antrian.proses', $item->id) }}"
                    data-method="POST"
                    data-confirm="Yakin ingin memproses antrian ini?">
                    Proses
                </button>

                <button type="button"
                    class="ajaxAction px-4 py-2 rounded-xl bg-red-500 hover:bg-red-600 text-white text-xs font-medium transition shadow-sm"
                    data-url="{{ route('petugas.antrian.batalkan', $item->id) }}"
                    data-method="POST"
                    data-confirm="Yakin ingin membatalkan antrian ini?">
                    Batalkan
                </button>
            @endif

            @if($item->status === 'diproses')
                <button type="button"
                    class="ajaxAction px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-medium transition shadow-sm"
                    data-url="{{ route('petugas.antrian.selesai', $item->id) }}"
                    data-method="POST"
                    data-confirm="Yakin ingin menyelesaikan antrian dan meminjamkan buku?">
                    Selesaikan
                </button>

                <button type="button"
                    class="ajaxAction px-4 py-2 rounded-xl bg-red-500 hover:bg-red-600 text-white text-xs font-medium transition shadow-sm"
                    data-url="{{ route('petugas.antrian.batalkan', $item->id) }}"
                    data-method="POST"
                    data-confirm="Yakin ingin membatalkan antrian ini?">
                    Batalkan
                </button>
            @endif

            <button type="button"
                class="ajaxAction px-4 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-medium transition shadow-sm"
                data-url="{{ route('petugas.antrian.destroy', $item->id) }}"
                data-method="DELETE"
                data-confirm="Yakin ingin menghapus data antrian ini?">
                Hapus
            </button>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="px-5 py-12 text-center">
        <div class="flex flex-col items-center justify-center gap-2">
            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center">
                <svg class="w-7 h-7 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10m-12 9h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" />
                </svg>
            </div>
            <p class="text-slate-500 font-medium">Tidak ada data antrian peminjaman ditemukan.</p>
            <p class="text-slate-400 text-sm">Coba ubah pencarian atau filter status.</p>
        </div>
    </td>
</tr>
@endforelse