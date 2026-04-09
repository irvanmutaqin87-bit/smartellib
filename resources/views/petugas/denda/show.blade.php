@extends('layouts.dashboard_petugas')

@section('title', 'Detail Denda')

@section('header')
<span class="text-2xl font-semibold">Detail Denda</span>
@endsection

@section('content')

<!-- Badge -->
<div class="flex items-center gap-2 mb-5">
    <span class="px-4 py-2 text-white text-sm font-semibold rounded-lg shadow-sm bg-cyan-900/80">
        Detail Denda
    </span>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

    <div class="flex flex-col xl:flex-row gap-8">

        <!-- ================= KIRI ================= -->
        <div class="flex flex-col sm:flex-row gap-6 flex-1">

            <!-- COVER BUKU -->
            <div class="w-full sm:w-52 h-72 bg-slate-100 rounded-xl border border-slate-200 overflow-hidden flex items-center justify-center shrink-0">
                @if($denda->peminjaman->buku->cover)
                    <img 
                        src="{{ asset('storage/' . $denda->peminjaman->buku->cover) }}" 
                        class="w-full h-full object-cover"
                        alt="Cover Buku"
                    >
                @else
                    <svg class="w-12 h-12 text-slate-300" fill="none" viewBox="0 0 24 24">
                        <path d="M6 4h12v16H6z" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                @endif
            </div>

            <!-- INFO -->
            <div class="flex-1">

                <h2 class="text-2xl font-bold text-slate-800">
                    {{ $denda->peminjaman->buku->judul ?? '-' }}
                </h2>

                <p class="text-slate-400 text-sm mb-6">
                    {{ $denda->peminjaman->anggota->nama_lengkap ?? '-' }}
                </p>

                <div class="space-y-3 text-sm">

                    <div class="flex gap-3">
                        <span class="w-44 text-slate-400">Kode Buku</span>
                        <span class="font-semibold text-slate-700">
                            : {{ $denda->peminjaman->buku->kode_buku ?? '-' }}
                        </span>
                    </div>

                    <div class="flex gap-3">
                        <span class="w-44 text-slate-400">Tanggal Pinjam</span>
                        <span class="font-semibold text-slate-700">
                            : {{ \Carbon\Carbon::parse($denda->peminjaman->tanggal_mulai)->format('d M Y') }}
                        </span>
                    </div>

                    <div class="flex gap-3">
                        <span class="w-44 text-slate-400">Jatuh Tempo</span>
                        <span class="font-semibold text-slate-700">
                            : {{ \Carbon\Carbon::parse($denda->peminjaman->tanggal_jatuh_tempo)->format('d M Y') }}
                        </span>
                    </div>

                    <div class="flex gap-3">
                        <span class="w-44 text-slate-400">Tanggal Kembali</span>
                        <span class="font-semibold text-slate-700">
                            : {{ $denda->peminjaman->tanggal_kembali 
                                ? \Carbon\Carbon::parse($denda->peminjaman->tanggal_kembali)->format('d M Y') 
                                : '-' }}
                        </span>
                    </div>

                    <div class="flex gap-3 items-center">
                        <span class="w-44 text-slate-400">Status Peminjaman</span>
                        @if($denda->peminjaman->status === 'dipinjam')
                            <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">Dipinjam</span>
                        @elseif($denda->peminjaman->status === 'dikembalikan')
                            <span class="px-3 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700">Dikembalikan</span>
                        @else
                            <span class="px-3 py-1 text-xs rounded-full bg-rose-100 text-rose-700">Terlambat</span>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <!-- ================= KANAN ================= -->
        <div class="w-full xl:w-80 space-y-5">

            <!-- BOX INFORMASI DENDA -->
            <div class="bg-slate-50 rounded-xl border border-slate-200 overflow-hidden">
                <div class="bg-slate-200 px-4 py-3 font-semibold text-sm">
                    Informasi Denda
                </div>

                <div class="p-4 space-y-4 text-sm">

                    <div class="flex justify-between">
                        <span class="text-slate-400">Status Denda</span>
                        @if($denda->status_denda === 'belum_bayar')
                            <span class="px-3 py-1 text-xs rounded-full bg-rose-100 text-rose-700">Belum Bayar</span>
                        @elseif($denda->status_denda === 'menunggu_verifikasi')
                            <span class="px-3 py-1 text-xs rounded-full bg-amber-100 text-amber-700">Menunggu Verifikasi</span>
                        @elseif($denda->status_denda === 'lunas')
                            <span class="px-3 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700">Lunas</span>
                        @else
                            <span class="px-3 py-1 text-xs rounded-full bg-slate-100 text-slate-700">Ditolak</span>
                        @endif
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-400">Terlambat</span>
                        <span class="font-semibold text-slate-700">
                            {{ $denda->hari_terlambat ?? 0 }} hari
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-400">Denda / Hari</span>
                        <span class="font-semibold text-slate-700">
                            Rp {{ number_format($denda->denda_per_hari ?? 0, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-400">Total Denda</span>
                        <span class="text-red-500 font-bold">
                            Rp {{ number_format($denda->jumlah_denda ?? 0, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-400">Tanggal Verifikasi</span>
                        <span class="font-semibold text-slate-700 text-right">
                            {{ $denda->tanggal_verifikasi ? \Carbon\Carbon::parse($denda->tanggal_verifikasi)->format('d M Y H:i') : '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-400">Diverifikasi Oleh</span>
                        <span class="font-semibold text-slate-700 text-right">
                            {{ $denda->verifikator->nama_petugas ?? '-' }}
                        </span>
                    </div>

                </div>
            </div>

            <!-- BOX CATATAN -->
            <div class="bg-white rounded-xl border border-slate-200 p-4">
                <h3 class="font-semibold text-slate-700 mb-3 text-sm">Catatan Verifikasi</h3>

                <div class="text-sm text-slate-600 leading-relaxed min-h-[80px]">
                    {{ $denda->catatan_verifikasi ?: 'Belum ada catatan verifikasi.' }}
                </div>
            </div>
        </div>
    </div>

    <!-- ================= BUKTI PEMBAYARAN ================= -->
    <div class="mt-8 pt-8 border-t border-slate-200">

        <h3 class="text-lg font-semibold text-slate-800 mb-4">
            Bukti Pembayaran
        </h3>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Preview Bukti -->
            <div class="bg-slate-50 rounded-2xl border border-slate-200 p-4">
                <div class="mb-3 text-sm font-semibold text-slate-700">
                    Preview Bukti Transfer / QRIS
                </div>

                @if($denda->bukti_pembayaran)
                    <div class="rounded-xl overflow-hidden border border-slate-200 bg-white">
                        <img 
                            src="{{ asset('storage/' . $denda->bukti_pembayaran) }}"
                            alt="Bukti Pembayaran"
                            class="w-full max-h-[500px] object-contain bg-slate-50"
                        >
                    </div>

                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="{{ asset('storage/' . $denda->bukti_pembayaran) }}" 
                           target="_blank"
                           class="px-4 py-2 rounded-xl bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-medium transition">
                            Lihat Full
                        </a>

                        <a href="{{ asset('storage/' . $denda->bukti_pembayaran) }}" 
                           download
                           class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium transition">
                            Download
                        </a>
                    </div>
                @else
                    <div class="h-72 rounded-xl border border-dashed border-slate-300 flex items-center justify-center text-slate-400 text-sm bg-white">
                        Belum ada bukti pembayaran yang diupload.
                    </div>
                @endif
            </div>

            <!-- Aksi Verifikasi -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5">
                <div class="mb-4">
                    <h4 class="text-base font-semibold text-slate-800">Aksi Petugas</h4>
                    <p class="text-sm text-slate-400 mt-1">
                        Verifikasi atau tolak bukti pembayaran denda anggota.
                    </p>
                </div>

                @if($denda->status_denda === 'menunggu_verifikasi')
                    <form id="formVerifikasi" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Catatan Verifikasi / Penolakan
                            </label>
                            <textarea 
                                id="catatan_verifikasi"
                                name="catatan_verifikasi"
                                rows="5"
                                class="w-full rounded-xl border border-slate-300 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 text-sm px-4 py-3 resize-none"
                                placeholder="Contoh: Bukti pembayaran valid, nominal sesuai."></textarea>
                        </div>

                        <div class="flex flex-wrap gap-3 pt-2">
                            <button type="button"
                                id="btnVerifikasi"
                                class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition">
                                Verifikasi Pembayaran
                            </button>

                            <button type="button"
                                id="btnTolak"
                                class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold transition">
                                Tolak Bukti
                            </button>
                        </div>
                    </form>
                @elseif($denda->status_denda === 'lunas')
                    <div class="rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-4 text-sm text-emerald-700">
                        Pembayaran denda sudah diverifikasi dan dinyatakan <strong>lunas</strong>.
                    </div>
                @elseif($denda->status_denda === 'ditolak')
                    <div class="rounded-xl bg-rose-50 border border-rose-200 px-4 py-4 text-sm text-rose-700">
                        Bukti pembayaran sebelumnya telah <strong>ditolak</strong>. Anggota perlu upload ulang.
                    </div>
                @else
                    <div class="rounded-xl bg-slate-50 border border-slate-200 px-4 py-4 text-sm text-slate-600">
                        Belum ada bukti pembayaran yang siap diverifikasi.
                    </div>
                @endif
            </div>

        </div>
    </div>

    <!-- ================= RIWAYAT PEMBAYARAN ================= -->
    @if($denda->bayarDenda)
    <div class="mt-8 pt-8 border-t border-slate-200">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">
            Riwayat Pembayaran
        </h3>

        <div class="bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-0 text-sm">
                <div class="p-4 border-b md:border-b-0 md:border-r border-slate-200">
                    <p class="text-slate-400 mb-1">Tanggal Bayar</p>
                    <p class="font-semibold text-slate-700">
                        {{ \Carbon\Carbon::parse($denda->bayarDenda->tanggal_bayar)->format('d M Y H:i') }}
                    </p>
                </div>

                <div class="p-4 border-b md:border-b-0 md:border-r border-slate-200">
                    <p class="text-slate-400 mb-1">Jumlah Bayar</p>
                    <p class="font-semibold text-emerald-600">
                        Rp {{ number_format($denda->bayarDenda->jumlah_bayar, 0, ',', '.') }}
                    </p>
                </div>

                <div class="p-4 border-b md:border-b-0 md:border-r border-slate-200">
                    <p class="text-slate-400 mb-1">Metode</p>
                    <p class="font-semibold text-slate-700">
                        {{ $denda->bayarDenda->metode_bayar ?? '-' }}
                    </p>
                </div>

                <div class="p-4">
                    <p class="text-slate-400 mb-1">Status</p>
                    <p class="font-semibold text-emerald-600">
                        Berhasil
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- BUTTON -->
    <div class="mt-8 pt-6 border-t border-slate-200 flex flex-wrap gap-3">
        <a href="{{ route('petugas.denda.index') }}"
           class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 rounded-xl text-sm font-medium text-slate-700 transition">
            Kembali
        </a>

        <a href="{{ route('petugas.peminjaman.show', $denda->peminjaman->id) }}"
           class="px-6 py-2.5 bg-cyan-50 hover:bg-cyan-100 text-cyan-700 rounded-xl text-sm font-medium transition">
            Lihat Detail Peminjaman
        </a>
    </div>

</div>

@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const btnVerifikasi = document.getElementById("btnVerifikasi");
    const btnTolak = document.getElementById("btnTolak");
    const catatan = document.getElementById("catatan_verifikasi");

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `
            fixed top-6 right-6 z-[9999] px-5 py-3 rounded-2xl shadow-2xl text-white text-sm font-medium
            ${type === 'success' ? 'bg-emerald-600' : 'bg-rose-600'}
        `;
        toast.innerText = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-2');
            toast.style.transition = 'all .3s ease';
        }, 2500);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    if (btnVerifikasi) {
        btnVerifikasi.addEventListener("click", async function () {
            if (!confirm("Yakin ingin memverifikasi pembayaran denda ini?")) return;

            btnVerifikasi.disabled = true;
            btnVerifikasi.innerText = "Memproses...";

            try {
                const response = await fetch("{{ route('petugas.denda.verifikasi', $denda->id) }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        catatan_verifikasi: catatan.value
                    })
                });

                const result = await response.json();

                if (result.success) {
                    showToast(result.message, 'success');
                    setTimeout(() => location.reload(), 1200);
                } else {
                    showToast(result.message || "Gagal memverifikasi.", 'error');
                }
            } catch (error) {
                showToast("Terjadi kesalahan saat verifikasi.", 'error');
            } finally {
                btnVerifikasi.disabled = false;
                btnVerifikasi.innerText = "Verifikasi Pembayaran";
            }
        });
    }

    if (btnTolak) {
        btnTolak.addEventListener("click", async function () {
            if (!confirm("Yakin ingin menolak bukti pembayaran ini?")) return;

            if (!catatan.value.trim()) {
                showToast("Catatan penolakan wajib diisi.", 'error');
                return;
            }

            btnTolak.disabled = true;
            btnTolak.innerText = "Memproses...";

            try {
                const response = await fetch("{{ route('petugas.denda.tolak', $denda->id) }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        catatan_verifikasi: catatan.value
                    })
                });

                const result = await response.json();

                if (result.success) {
                    showToast(result.message, 'success');
                    setTimeout(() => location.reload(), 1200);
                } else {
                    showToast(result.message || "Gagal menolak pembayaran.", 'error');
                }
            } catch (error) {
                showToast("Terjadi kesalahan saat penolakan.", 'error');
            } finally {
                btnTolak.disabled = false;
                btnTolak.innerText = "Tolak Bukti";
            }
        });
    }
});
</script>
@endsection