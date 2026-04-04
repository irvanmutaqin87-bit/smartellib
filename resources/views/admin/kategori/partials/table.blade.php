@if($data->count() > 0)
    @foreach($data as $index => $kategori)
    <tr class="border-b hover:bg-slate-50 transition">
        <td class="px-5 py-4 text-slate-600 text-center">{{ $data->firstItem() + $index }}</td>
        <td class="px-5 py-4 text-slate-700">{{ $kategori->nama_kategori }}</td>
        <td class="px-5 py-4 text-center text-slate-600">{{ $kategori->buku_count ?? 0 }}</td>
        <td class="px-5 py-4 text-center">
            <div class="flex justify-center gap-2">
                <a href="{{ route('admin.kategori.edit', ['id' => $kategori->id]) }}"
                    class="px-3 py-1.5 bg-slate-100 text-slate-700 rounded-lg text-xs"
                    data-url="{{ route('admin.kategori.edit', ['id' => $kategori->id]) }}">
                    Edit
                </a>

                <button class="ajaxAction px-3 py-1.5 bg-red-100 text-red-600 rounded-lg text-xs"
                        data-url="{{ route('admin.kategori.delete', ['id' => $kategori->id]) }}"
                        data-confirm="Hapus kategori ini?">
                    Hapus
                </button>
            </div>
        </td>
    </tr>
    @endforeach
@else
    <tr>
        <td colspan="4" class="px-5 py-10 text-center text-slate-400 text-sm">
            Data kategori tidak ditemukan.
        </td>
    </tr>
@endif