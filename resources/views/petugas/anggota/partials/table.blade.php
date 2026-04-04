
            @forelse ($anggota as $index => $user)
            <tr 
                data-status="{{ $user->status }}"
                class="border-b border-slate-100 hover:bg-slate-50 transition">

                <!-- NOMOR -->
                <td class="px-5 py-4 text-slate-600">
                    {{ $anggota->firstItem() + $index }}
                </td>

                <!-- NAMA -->
                <td class="px-5 py-4 font-medium text-slate-800">
                    {{ $user->nama }}
                </td>

                <!-- EMAIL -->
                <td class="px-5 py-4 text-slate-600">
                    {{ $user->email }}
                </td>

                <!-- STATUS -->
                <td class="px-5 py-4">
                    @if ($user->status == 'aktif')
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600 border border-emerald-100">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Aktif
                        </span>
                    @elseif ($user->status == 'pending')
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-yellow-50 text-yellow-600 border border-yellow-100">
                            <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                            Pending
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                            <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                            Nonaktif
                        </span>
                    @endif
                </td>

                <!-- AKSI -->
                <td class="px-5 py-4 text-center">
                    <div class="relative inline-block">

                        <!-- BUTTON -->
                        <button type="button"
                            class="bookActionBtn w-10 h-10 rounded-xl flex items-center justify-center hover:bg-slate-100 transition">
                            ⋯
                        </button>

                        <!-- DROPDOWN -->
                        <div class="bookActionDropdown absolute right-full top-1/2 -translate-y-1/2 mr-3 w-52 bg-white rounded-2xl shadow-xl border border-slate-200 p-2 z-50
                            origin-right scale-95 opacity-0 translate-x-2 pointer-events-none transition-all duration-300">

                            <!-- DETAIL -->
                            <a href="{{ route('petugas.anggota.show', $user->id) }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-slate-700 hover:bg-slate-50 transition">
                                Detail Anggota
                            </a>

                            @if ($user->status == 'pending')
                            <button 
                                class="ajaxAction w-full text-left px-4 py-3 rounded-xl text-sm text-emerald-600 hover:bg-emerald-50 transition"
                                data-url="{{ route('petugas.anggota.verifikasi', $user->id) }}"
                                data-confirm="Verifikasi anggota ini?"
                            >
                                Verifikasi Anggota
                            </button>
                            @endif

                            @if ($user->status == 'aktif')
                            <button 
                                class="ajaxAction w-full text-left px-4 py-3 rounded-xl text-sm text-red-600 hover:bg-red-50 transition"
                                data-url="{{ route('petugas.anggota.nonaktifkan', $user->id) }}"
                                data-confirm="Nonaktifkan anggota ini?"
                            >
                                Nonaktifkan Anggota
                            </button>
                            @endif

                            @if ($user->status == 'nonaktif')
                            <button 
                                class="ajaxAction w-full text-left px-4 py-3 rounded-xl text-sm text-blue-600 hover:bg-blue-50 transition"
                                data-url="{{ route('petugas.anggota.aktifkan', $user->id) }}"
                                data-confirm="Aktifkan kembali anggota ini?"
                            >
                                Aktifkan Anggota
                            </button>
                            @endif

                        </div>
                    </div>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-6 text-slate-400">
                    Tidak ada data anggota
                </td>
            </tr>
            @endforelse

            <tr id="emptyRow" style="display: none;">
                <td colspan="5" class="text-center py-6 text-slate-400">
                    Data anggota tidak ditemukan
                </td>
            </tr>
