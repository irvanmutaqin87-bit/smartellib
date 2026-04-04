@extends('layouts.dashboard_admin')

@section('title', 'Pengaturan Sistem - SMARTELLIB')

@section('header')
<span class="text-2xl font-semibold">Pengaturan Sistem</span>
@endsection

@section('content')

<div class="relative">

    <!-- TOAST -->
    <div id="toastContainer" class="absolute left-1/2 -translate-x-1/2 top-0 z-50"></div>

    <!-- FORM AJAX -->
    <form id="pengaturanForm"
          action="{{ route('admin.pengaturan.update') }}"
          method="POST"
          enctype="multipart/form-data"
          data-reset-on-success="false">
        @csrf

        <!-- Breadcrumb -->
        <div class="flex items-center justify-between mb-5">
            <span class="px-4 py-2 text-white text-sm font-semibold rounded-lg shadow-sm bg-cyan-900/80">
                Pengaturan Sistem
            </span>

            <button
                type="submit"
                class="bg-cyan-700 hover:bg-cyan-800 text-white text-sm px-4 py-2.5 rounded-xl shadow-sm transition">
                Simpan Perubahan
            </button>
        </div>

        <!-- CARD 1 -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-5">
            <h2 class="text-base font-semibold text-slate-700 mb-5">
                Pengaturan Peminjaman
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Lama Peminjaman -->
                <div>
                    <label class="text-xs text-slate-400">
                        Lama Peminjaman (Hari)
                    </label>
                    <input 
                        type="number"
                        name="lama_peminjaman"
                        min="1"
                        max="60"
                        value="{{ old('lama_peminjaman', $pengaturan->lama_peminjaman) }}"
                        placeholder="Contoh: 7"
                        class="mt-1 w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:border-cyan-700 transition"
                    />
                    <small class="error-message text-red-500 text-xs mt-1 block" data-field="lama_peminjaman"></small>
                </div>

                <!-- Batas Peminjaman -->
                <div>
                    <label class="text-xs text-slate-400">
                        Batas Maksimal Peminjaman
                    </label>
                    <input 
                        type="number"
                        name="batas_peminjaman"
                        min="1"
                        max="20"
                        value="{{ old('batas_peminjaman', $pengaturan->batas_peminjaman) }}"
                        placeholder="Contoh: 3 buku"
                        class="mt-1 w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:border-cyan-700 transition"
                    />
                    <small class="error-message text-red-500 text-xs mt-1 block" data-field="batas_peminjaman"></small>
                </div>

                <!-- Denda -->
                <div class="md:col-span-2">
                    <label class="text-xs text-slate-400">
                        Denda Per Hari (Rp)
                    </label>
                    <input 
                        type="number"
                        name="denda_per_hari"
                        min="0"
                        step="0.01"
                        value="{{ old('denda_per_hari', $pengaturan->denda_per_hari) }}"
                        placeholder="Contoh: 1000"
                        class="mt-1 w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:border-cyan-700 transition"
                    />
                    <small class="error-message text-red-500 text-xs mt-1 block" data-field="denda_per_hari"></small>
                </div>

            </div>
        </div>

        <!-- CARD 2 -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-base font-semibold text-slate-700 mb-5">
                Pengaturan Pembayaran Denda
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- CUSTOM DROPDOWN METODE PEMBAYARAN -->
                <div class="relative z-40">
                    <label class="block text-xs text-slate-400 mb-2">
                        Metode Pembayaran Denda
                    </label>

                    <div class="relative">
                        <button type="button" id="metodePembayaranBtn"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-600 shadow-sm cursor-pointer hover:border-cyan-700 outline-none focus:outline-none focus:ring-0 active:ring-0 transition-colors flex items-center justify-between">
                            <span id="metodePembayaranText">
                                {{ old('metode_pembayaran_denda', $pengaturan->metode_pembayaran_denda) ?: 'Pilih Metode Pembayaran' }}
                            </span>
                            <svg id="metodePembayaranIcon"
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 transition-all duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div id="metodePembayaranDropdown"
                            class="absolute left-0 top-full mt-3 w-full bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-slate-200 p-2 z-[999]
                            origin-top transform scale-y-95 opacity-0 -translate-y-2 pointer-events-none
                            transition-all duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]">

                            <button type="button"
                                class="metodePembayaranOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-cyan-50 hover:text-cyan-800 text-sm text-slate-700 transition"
                                data-value="QRIS">
                                QRIS
                            </button>

                            <button type="button"
                                class="metodePembayaranOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-cyan-50 hover:text-cyan-800 text-sm text-slate-700 transition"
                                data-value="GoPay">
                                GoPay
                            </button>

                            <button type="button"
                                class="metodePembayaranOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-cyan-50 hover:text-cyan-800 text-sm text-slate-700 transition"
                                data-value="DANA">
                                DANA
                            </button>

                            <button type="button"
                                class="metodePembayaranOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-cyan-50 hover:text-cyan-800 text-sm text-slate-700 transition"
                                data-value="OVO">
                                OVO
                            </button>

                            <button type="button"
                                class="metodePembayaranOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-cyan-50 hover:text-cyan-800 text-sm text-slate-700 transition"
                                data-value="Transfer Bank">
                                Transfer Bank
                            </button>
                        </div>

                        <input type="hidden"
                               name="metode_pembayaran_denda"
                               id="metodePembayaranInput"
                               value="{{ old('metode_pembayaran_denda', $pengaturan->metode_pembayaran_denda) }}">
                    </div>

                    <small class="error-message text-red-500 text-xs mt-2 block" data-field="metode_pembayaran_denda"></small>
                </div>

                <!-- Nama E-Wallet -->
                <div>
                    <label class="text-xs text-slate-400">
                        Nama E-Wallet / Nama Akun
                    </label>
                    <input 
                        type="text"
                        name="nama_ewallet"
                        value="{{ old('nama_ewallet', $pengaturan->nama_ewallet) }}"
                        placeholder="Contoh: GoPay Perpustakaan"
                        class="mt-1 w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:border-cyan-700 transition"
                    />
                    <small class="error-message text-red-500 text-xs mt-1 block" data-field="nama_ewallet"></small>
                </div>

                <!-- Nomor Pembayaran -->
                <div>
                    <label class="text-xs text-slate-400">
                        Nomor Pembayaran / Nomor HP / No Rekening
                    </label>
                    <input 
                        type="text"
                        name="nomor_pembayaran"
                        value="{{ old('nomor_pembayaran', $pengaturan->nomor_pembayaran) }}"
                        placeholder="Contoh: 08123456789"
                        class="mt-1 w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:border-cyan-700 transition"
                    />
                    <small class="error-message text-red-500 text-xs mt-1 block" data-field="nomor_pembayaran"></small>
                </div>

                <!-- Upload QR -->
                <div>
                    <label class="text-xs text-slate-400">
                        Upload QR Pembayaran
                    </label>
                    <input 
                        type="file"
                        name="qr_pembayaran"
                        id="qrPembayaranInput"
                        accept=".jpg,.jpeg,.png,.webp,image/*"
                        class="mt-1 w-full border border-slate-100 rounded-2xl px-5 py-3 text-sm text-slate-700 bg-white focus:outline-none focus:border-cyan-700 transition"
                    />
                    <small class="error-message text-red-500 text-xs mt-1 block" data-field="qr_pembayaran"></small>
                </div>

                <!-- Preview QR -->
                @if($pengaturan->qr_pembayaran)
                    <div class="md:col-span-2" id="qrPreviewWrapper">
                        <label class="text-xs text-slate-400 block mb-2">
                            QR Pembayaran Saat Ini
                        </label>
                        <div class="w-44 h-44 rounded-2xl border border-slate-200 p-3 bg-slate-50 flex items-center justify-center overflow-hidden">
                            <img id="qrPreviewImage"
                                src="{{ $pengaturan->qr_pembayaran ? asset('storage/' . $pengaturan->qr_pembayaran) : '' }}"
                                alt="QR Pembayaran"
                                class="max-w-full max-h-full object-contain rounded-xl {{ $pengaturan->qr_pembayaran ? '' : 'hidden' }}">
                            <span id="qrPreviewPlaceholder"
                                class="text-xs text-slate-400 {{ $pengaturan->qr_pembayaran ? 'hidden' : '' }}">
                                Belum ada QR
                            </span>
                        </div>
                    </div>
                @endif

                <!-- Catatan -->
                <div class="md:col-span-2">
                    <label class="text-xs text-slate-400">
                        Catatan Pembayaran
                    </label>
                    <textarea
                        name="catatan_pembayaran"
                        rows="4"
                        placeholder="Contoh: Transfer sesuai nominal denda lalu upload bukti pembayaran."
                        class="mt-1 w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:border-cyan-700 transition resize-none">{{ old('catatan_pembayaran', $pengaturan->catatan_pembayaran) }}</textarea>
                    <small class="error-message text-red-500 text-xs mt-1 block" data-field="catatan_pembayaran"></small>
                </div>

            </div>
        </div>
    </form>

    <!-- Info Tambahan -->
    <div class="mt-5 bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
        <h2 class="text-sm font-semibold text-slate-700 mb-3">
            Informasi
        </h2>

        <ul class="text-sm text-slate-500 space-y-2">
            <li>• Lama peminjaman menentukan batas waktu pengembalian buku</li>
            <li>• Batas peminjaman adalah jumlah maksimal buku yang bisa dipinjam anggota</li>
            <li>• Denda dihitung per hari keterlambatan</li>
            <li>• Data pembayaran denda akan ditampilkan ke anggota saat membayar denda</li>
        </ul>
    </div>

</div>
@endsection