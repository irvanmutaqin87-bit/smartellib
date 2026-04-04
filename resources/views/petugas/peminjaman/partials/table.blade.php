@forelse($data as $index => $item)
<tr class="border-b border-slate-100 hover:bg-slate-50 transition">

    <!-- NO -->
    <td class="px-5 py-4 text-slate-600">
        {{ ($data->currentPage() - 1) * $data->perPage() + $index + 1 }}
    </td>

    <!-- ANGGOTA -->
    <td class="px-5 py-4">
        <div class="font-medium text-slate-800">
            {{ $item->anggota->user->nama ?? '-' }}
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

    <!-- TANGGAL -->
    <td class="px-5 py-4 text-slate-600">
        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
    </td>

    <td class="px-5 py-4 text-slate-600">
        {{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d M Y') }}
    </td>

    <!-- STATUS -->
    <td class="px-5 py-4">
        @if($item->status === 'dipinjam')
            <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">Dipinjam</span>
        @elseif($item->status === 'dikembalikan')
            <span class="px-3 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700">Dikembalikan</span>
        @else
            <span class="px-3 py-1 text-xs rounded-full bg-rose-100 text-rose-700">Terlambat</span>
        @endif
    </td>

    <!-- DENDA -->
    <td class="px-5 py-4">
        @if($item->denda)
            <span class="text-red-500 font-semibold">
                Rp {{ number_format($item->denda->jumlah_denda, 0, ',', '.') }}
            </span>
        @else
            <span class="text-slate-400">-</span>
        @endif
    </td>

    <!-- AKSI -->
    <td class="px-5 py-4 text-center">
        <a href="{{ route('petugas.peminjaman.show', $item->id) }}"
           class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-medium transition shadow-sm">
            Detail
        </a>
    </td>

</tr>
@empty
<tr>
    <td colspan="8" class="px-5 py-12 text-center text-slate-400">
        Tidak ada data peminjaman.
    </td>
</tr>
@endforelse