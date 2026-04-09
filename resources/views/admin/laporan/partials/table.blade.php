<div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            @if($jenis === 'peminjaman')
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider w-10">No.</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Anggota</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Judul Buku</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Tgl Pinjam</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Jatuh Tempo</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Status</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Denda</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Aksi</th>
                </tr>
            @elseif($jenis === 'pengembalian')
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider w-10">No.</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Nama</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Judul Buku</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Tgl Kembali</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Terlambat</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Status</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Aksi</th>
                </tr>
            @elseif($jenis === 'denda')
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider w-10">No.</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Nama</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Judul Buku</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Terlambat</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Jumlah</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Status</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-slate-400 text-xs uppercase tracking-wider">Aksi</th>
                </tr>
            @endif
        </thead>

        <tbody>
            @forelse($data as $index => $item)

                @if($jenis === 'peminjaman')
                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                        <td class="px-5 py-4 text-slate-600">
                            {{ ($data->currentPage() - 1) * $data->perPage() + $index + 1 }}
                        </td>

                        <td class="px-5 py-4 font-medium text-slate-800">
                            {{ $item->anggota->user->nama ?? '-' }}
                        </td>

                        <td class="px-5 py-4 text-slate-600">
                            {{ $item->buku->judul ?? '-' }}
                        </td>

                        <td class="px-5 py-4 text-slate-600">
                            {{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') : '-' }}
                        </td>

                        <td class="px-5 py-4 text-slate-600">
                            {{ $item->tanggal_jatuh_tempo ? \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d/m/Y') : '-' }}
                        </td>

                        <td class="px-5 py-4">
                            @if($item->status === 'dipinjam')
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-600 border border-amber-100">
                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                    Dipinjam
                                </span>
                            @elseif($item->status === 'dikembalikan')
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600 border border-emerald-100">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    Dikembalikan
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-600 border border-red-100">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                    Terlambat
                                </span>
                            @endif
                        </td>

                        <td class="px-5 py-4 text-slate-600">
                            Rp {{ number_format($item->denda->jumlah_denda ?? 0, 0, ',', '.') }}
                        </td>

                        <td class="px-5 py-4 text-center">
                            <button type="button"
                                class="laporanDetailBtn inline-flex items-center justify-center w-10 h-10 rounded-xl hover:bg-slate-100 transition"
                                data-jenis="peminjaman"
                                data-kode="{{ $item->kode_peminjaman }}"
                                data-nama="{{ $item->anggota->user->nama ?? '-' }}"
                                data-buku="{{ $item->buku->judul ?? '-' }}"
                                data-kodebuku="{{ $item->buku->kode_buku ?? '-' }}"
                                data-tglpinjam="{{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') : '-' }}"
                                data-jatuhtempo="{{ $item->tanggal_jatuh_tempo ? \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d/m/Y') : '-' }}"
                                data-tglkembali="{{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') : '-' }}"
                                data-status="{{ ucfirst($item->status) }}"
                                data-denda="Rp {{ number_format($item->denda->jumlah_denda ?? 0, 0, ',', '.') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0A9 9 0 1112 3a9 9 0 019 9z" />
                                </svg>
                            </button>
                        </td>
                    </tr>

                @elseif($jenis === 'pengembalian')
                    @php
                        $terlambatHari = 0;
                        if ($item->tanggal_kembali && $item->tanggal_jatuh_tempo) {
                            $tglKembali = \Carbon\Carbon::parse($item->tanggal_kembali);
                            $jatuhTempo = \Carbon\Carbon::parse($item->tanggal_jatuh_tempo);
                            $terlambatHari = max(0, $jatuhTempo->diffInDays($tglKembali, false));
                        }
                    @endphp

                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                        <td class="px-5 py-4 text-slate-600">
                            {{ ($data->currentPage() - 1) * $data->perPage() + $index + 1 }}
                        </td>

                        <td class="px-5 py-4 font-medium text-slate-800">
                            {{ $item->anggota->user->nama ?? '-' }}
                        </td>

                        <td class="px-5 py-4 text-slate-600">
                            {{ $item->buku->judul ?? '-' }}
                        </td>

                        <td class="px-5 py-4 text-slate-600">
                            {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') : '-' }}
                        </td>

                        <td class="px-5 py-4 text-slate-600">
                            {{ $terlambatHari }} hari
                        </td>

                        <td class="px-5 py-4">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600 border border-emerald-100">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Dikembalikan
                            </span>
                        </td>

                        <td class="px-5 py-4 text-center">
                            <button type="button"
                                class="laporanDetailBtn inline-flex items-center justify-center w-10 h-10 rounded-xl hover:bg-slate-100 transition"
                                data-jenis="pengembalian"
                                data-kode="{{ $item->kode_peminjaman }}"
                                data-nama="{{ $item->anggota->user->nama ?? '-' }}"
                                data-buku="{{ $item->buku->judul ?? '-' }}"
                                data-tglpinjam="{{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') : '-' }}"
                                data-jatuhtempo="{{ $item->tanggal_jatuh_tempo ? \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d/m/Y') : '-' }}"
                                data-tglkembali="{{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') : '-' }}"
                                data-terlambat="{{ $terlambatHari }} hari">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0A9 9 0 1112 3a9 9 0 019 9z" />
                                </svg>
                            </button>
                        </td>
                    </tr>

                @elseif($jenis === 'denda')
                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                        <td class="px-5 py-4 text-slate-600">
                            {{ ($data->currentPage() - 1) * $data->perPage() + $index + 1 }}
                        </td>

                        <td class="px-5 py-4 font-medium text-slate-800">
                            {{ $item->peminjaman->anggota->nama ?? '-' }}
                        </td>

                        <td class="px-5 py-4 text-slate-600">
                            {{ $item->peminjaman->buku->judul ?? '-' }}
                        </td>

                        <td class="px-5 py-4 text-slate-600">
                            {{ $item->hari_terlambat ?? 0 }} hari
                        </td>

                        <td class="px-5 py-4 text-slate-600">
                            Rp {{ number_format($item->jumlah_denda ?? 0, 0, ',', '.') }}
                        </td>

                        <td class="px-5 py-4">
                            @php
                                $status = $item->status_denda ?? '';
                            @endphp

                            @if($status === 'lunas')
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600 border border-emerald-100">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    Lunas
                                </span>
                            @elseif($status === 'menunggu_verifikasi')
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-600 border border-amber-100">
                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                    Menunggu
                                </span>
                            @elseif($status === 'ditolak')
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-600 border border-red-100">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                    Ditolak
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                    <span class="w-2 h-2 rounded-full bg-slate-500"></span>
                                    Belum Bayar
                                </span>
                            @endif
                        </td>

                        <td class="px-5 py-4 text-center">
                            <button type="button"
                                class="laporanDetailBtn inline-flex items-center justify-center w-10 h-10 rounded-xl hover:bg-slate-100 transition"
                                data-jenis="denda"
                                data-nama="{{ $item->peminjaman->anggota->nama ?? '-' }}"
                                data-buku="{{ $item->peminjaman->buku->judul ?? '-' }}"
                                data-terlambat="{{ $item->hari_terlambat ?? 0 }} hari"
                                data-jumlah="Rp {{ number_format($item->jumlah_denda ?? 0, 0, ',', '.') }}"
                                data-status="{{ ucfirst(str_replace('_', ' ', $item->status_denda)) }}"
                                data-dibuat="{{ $item->created_at ? $item->created_at->format('d/m/Y') : '-' }}"
                                data-verifikasi="{{ $item->tanggal_verifikasi ? \Carbon\Carbon::parse($item->tanggal_verifikasi)->format('d/m/Y') : '-' }}"
                                data-verifikator="{{ $item->verifikator->name ?? '-' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0A9 9 0 1112 3a9 9 0 019 9z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endif

            @empty
                <tr>
                    <td colspan="8" class="px-5 py-10 text-center text-slate-400">
                        Tidak ada data laporan ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>