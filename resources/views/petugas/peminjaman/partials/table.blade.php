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

    <td class="px-5 py-4 text-slate-600 align-top">
        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
    </td>

    <td class="px-5 py-4 text-slate-600 align-top">
        {{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d M Y') }}
    </td>

    <td class="px-5 py-4 align-top">
        @if($item->status === 'dipinjam')
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-600 border border-blue-100">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                Dipinjam
            </span>
        @elseif($item->status === 'dikembalikan')
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600 border border-emerald-100">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                Dikembalikan
            </span>
        @elseif($item->status === 'terlambat')
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-600 border border-red-100">
                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                Terlambat
            </span>
        @endif
    </td>

    <td class="px-5 py-4 align-top">
        @if($item->denda)
            <span class="text-red-500 font-semibold">
                Rp {{ number_format($item->denda->jumlah_denda, 0, ',', '.') }}
            </span>
        @else
            <span class="text-slate-400">-</span>
        @endif
    </td>

    <td class="px-5 py-4 text-center align-top">
        @if(in_array($item->status, ['dipinjam', 'terlambat']))
            <button type="button"
                class="ajaxAction px-4 py-2 rounded-xl bg-cyan-900/80 hover:bg-cyan-800 text-white text-xs font-medium transition shadow-sm"
                data-url="{{ route('petugas.peminjaman.kembalikan', $item->id) }}"
                data-method="POST"
                data-confirm="Yakin ingin mengembalikan buku ini?">
                Kembalikan
            </button>
        @else
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-medium">
                Selesai
            </span>
        @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="8" class="px-5 py-12 text-center">
        <div class="flex flex-col items-center justify-center gap-2">
            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center">
                <svg class="w-7 h-7 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" />
                </svg>
            </div>
            <p class="text-slate-500 font-medium">Tidak ada data peminjaman ditemukan.</p>
            <p class="text-slate-400 text-sm">Coba ubah pencarian atau filter status.</p>
        </div>
    </td>
</tr>
@endforelse