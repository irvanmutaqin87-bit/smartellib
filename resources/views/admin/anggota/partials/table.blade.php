
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
                      <a href="{{ route('admin.anggota.show', $user->id) }}"
                          class="px-4 py-2 rounded-lg bg-slate-100 text-slate-700 text-xs hover:bg-slate-200 transition">
                          Lihat Detail
                      </a>
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
