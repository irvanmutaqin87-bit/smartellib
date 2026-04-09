export function initLaporanPage() {
    if (window.location.pathname !== "/admin/laporan") return;

    const jenisInput = document.getElementById("jenisLaporanFilter");
    const statusWrapper = document.getElementById("statusOptionsWrapper");
    const statusText = document.getElementById("statusFilterText");
    const statusInput = document.getElementById("statusFilter");
    const downloadBtn = document.getElementById("downloadPdfBtn");
    const resetBtn = document.getElementById("resetLaporanFilter");

    const periodeInput = document.getElementById("periodeFilter");
    const searchInput = document.getElementById("searchInput");
    const tanggalDari = document.getElementById("tanggalDariFilter");
    const tanggalSampai = document.getElementById("tanggalSampaiFilter");
    const bulanFilter = document.getElementById("bulanFilter");
    const tahunFilter = document.getElementById("tahunFilter");

    const modal = document.getElementById("laporanDetailModal");
    const modalContent = document.getElementById("laporanDetailContent");
    const closeModalBtn = document.getElementById("closeLaporanDetailModal");

    if (!jenisInput || !statusWrapper || !downloadBtn) return;

    function renderStatusOptions(jenis) {
        let html = "";

        if (jenis === "peminjaman") {
            html = `
                <button type="button" class="statusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="">Semua Status</button>
                <button type="button" class="statusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="dipinjam">Dipinjam</button>
                <button type="button" class="statusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="dikembalikan">Dikembalikan</button>
                <button type="button" class="statusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="terlambat">Terlambat</button>
            `;
        } else if (jenis === "pengembalian") {
            html = `
                <button type="button" class="statusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="">Semua Status</button>
                <button type="button" class="statusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="dikembalikan">Dikembalikan</button>
            `;
        } else if (jenis === "denda") {
            html = `
                <button type="button" class="statusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="">Semua Status</button>
                <button type="button" class="statusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="belum_bayar">Belum Bayar</button>
                <button type="button" class="statusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="menunggu_verifikasi">Menunggu Verifikasi</button>
                <button type="button" class="statusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="lunas">Lunas</button>
                <button type="button" class="statusOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition" data-value="ditolak">Ditolak</button>
            `;
        }

        statusWrapper.innerHTML = html;
        bindStatusOptions();
    }

    function bindStatusOptions() {
        const dropdown = document.getElementById("statusFilterDropdown");
        const button = document.getElementById("statusFilterBtn");
        const icon = button?.querySelector("svg");

        statusWrapper.querySelectorAll(".statusOption").forEach((option) => {
            option.addEventListener("click", function () {
                const selectedText = this.innerText.trim();
                const selectedValue = this.dataset.value ?? "";

                statusInput.value = selectedValue;
                statusInput.dispatchEvent(
                    new Event("change", { bubbles: true }),
                );
                statusInput.dispatchEvent(
                    new Event("input", { bubbles: true }),
                );

                if (statusText) statusText.innerText = selectedText;

                dropdown?.classList.add(
                    "opacity-0",
                    "-translate-y-2",
                    "pointer-events-none",
                    "scale-y-95",
                );
                dropdown?.classList.remove(
                    "opacity-100",
                    "translate-y-0",
                    "pointer-events-auto",
                    "scale-y-100",
                );

                if (icon) icon.classList.remove("rotate-180");
            });
        });
    }

    function updateDownloadUrl() {
        const params = new URLSearchParams({
            jenis_laporan: jenisInput.value || "",
            periode: periodeInput?.value || "",
            status: statusInput?.value || "",
            search: searchInput?.value || "",
            tanggal_dari: tanggalDari?.value || "",
            tanggal_sampai: tanggalSampai?.value || "",
            bulan: bulanFilter?.value || "",
            tahun: tahunFilter?.value || "",
        });

        downloadBtn.href = `/admin/laporan/download-pdf?${params.toString()}`;
    }

    function resetFilters() {
        jenisInput.value = "peminjaman";
        periodeInput.value = "";
        statusInput.value = "";
        searchInput.value = "";
        tanggalDari.value = "";
        tanggalSampai.value = "";
        bulanFilter.value = "";
        tahunFilter.value = "";

        document.getElementById("jenisLaporanText").innerText =
            "Laporan Peminjaman";
        document.getElementById("periodeFilterText").innerText =
            "Semua Periode";
        document.getElementById("statusFilterText").innerText = "Semua Status";
        document.getElementById("bulanFilterText").innerText = "Semua Bulan";
        document.getElementById("tahunFilterText").innerText = "Semua Tahun";

        renderStatusOptions("peminjaman");

        [
            jenisInput,
            periodeInput,
            statusInput,
            searchInput,
            tanggalDari,
            tanggalSampai,
            bulanFilter,
            tahunFilter,
        ].forEach((el) => {
            if (el) {
                el.dispatchEvent(new Event("change", { bubbles: true }));
                el.dispatchEvent(new Event("input", { bubbles: true }));
            }
        });

        updateDownloadUrl();
    }

    function openModal(content) {
        if (!modal || !modalContent) return;
        modalContent.innerHTML = content;
        modal.classList.remove("hidden");
        modal.classList.add("flex");
    }

    function closeModal() {
        if (!modal) return;
        modal.classList.add("hidden");
        modal.classList.remove("flex");
    }

    function bindDetailButtons() {
        document.querySelectorAll(".laporanDetailBtn").forEach((btn) => {
            btn.addEventListener("click", function () {
                const jenis = this.dataset.jenis;

                let html = "";

                if (jenis === "peminjaman") {
                    html = `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            ${detailItem("Kode Peminjaman", this.dataset.kode)}
                            ${detailItem("Nama Anggota", this.dataset.nama)}
                            ${detailItem("Judul Buku", this.dataset.buku)}
                            ${detailItem("Kode Buku", this.dataset.kodebuku)}
                            ${detailItem("Tanggal Pinjam", this.dataset.tglpinjam)}
                            ${detailItem("Jatuh Tempo", this.dataset.jatuhtempo)}
                            ${detailItem("Tanggal Kembali", this.dataset.tglkembali)}
                            ${detailItem("Status", this.dataset.status)}
                            ${detailItem("Denda", this.dataset.denda)}
                        </div>
                    `;
                }

                if (jenis === "pengembalian") {
                    html = `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            ${detailItem("Kode Peminjaman", this.dataset.kode)}
                            ${detailItem("Nama Anggota", this.dataset.nama)}
                            ${detailItem("Judul Buku", this.dataset.buku)}
                            ${detailItem("Tanggal Pinjam", this.dataset.tglpinjam)}
                            ${detailItem("Jatuh Tempo", this.dataset.jatuhtempo)}
                            ${detailItem("Tanggal Kembali", this.dataset.tglkembali)}
                            ${detailItem("Terlambat", this.dataset.terlambat)}
                        </div>
                    `;
                }

                if (jenis === "denda") {
                    html = `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            ${detailItem("Nama Anggota", this.dataset.nama)}
                            ${detailItem("Judul Buku", this.dataset.buku)}
                            ${detailItem("Hari Terlambat", this.dataset.terlambat)}
                            ${detailItem("Jumlah Denda", this.dataset.jumlah)}
                            ${detailItem("Status", this.dataset.status)}
                            ${detailItem("Tanggal Dibuat", this.dataset.dibuat)}
                            ${detailItem("Tanggal Verifikasi", this.dataset.verifikasi)}
                            ${detailItem("Verifikator", this.dataset.verifikator)}
                        </div>
                    `;
                }

                openModal(html);
            });
        });
    }

    function detailItem(label, value) {
        return `
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">${label}</p>
                <p class="text-slate-700 font-medium">${value || "-"}</p>
            </div>
        `;
    }

    jenisInput.addEventListener("change", () => {
        statusInput.value = "";
        statusText.innerText = "Semua Status";
        renderStatusOptions(jenisInput.value);
        updateDownloadUrl();
    });

    [
        periodeInput,
        statusInput,
        searchInput,
        tanggalDari,
        tanggalSampai,
        bulanFilter,
        tahunFilter,
    ].forEach((el) => {
        if (el) {
            el.addEventListener("change", updateDownloadUrl);
            el.addEventListener("input", updateDownloadUrl);
        }
    });

    resetBtn?.addEventListener("click", resetFilters);
    closeModalBtn?.addEventListener("click", closeModal);

    modal?.addEventListener("click", function (e) {
        if (e.target === modal) closeModal();
    });

    // rebinding detail setelah ajax render
    const observer = new MutationObserver(() => {
        bindDetailButtons();
    });

    const tableContainer = document.getElementById("tableContainer");
    if (tableContainer) {
        observer.observe(tableContainer, { childList: true, subtree: true });
    }

    renderStatusOptions(jenisInput.value);
    bindDetailButtons();
    updateDownloadUrl();
}
