export function initPetugasDenda() {
    // =========================
    // TOLAK PEMBAYARAN DENGAN PROMPT
    // =========================
    document.addEventListener("click", async function (e) {
        const btn = e.target.closest(".ajaxSimpleAction");
        if (!btn) return;

        e.preventDefault();

        const url = btn.dataset.url;
        const method = btn.dataset.method || "POST";
        const confirmText = btn.dataset.confirm || "Yakin?";
        const promptText = btn.dataset.prompt || "Masukkan catatan";

        if (!confirm(confirmText)) return;

        const alasan = prompt(promptText);

        if (alasan === null) return; // user cancel
        if (alasan.trim() === "") {
            alert("Alasan penolakan wajib diisi.");
            return;
        }

        try {
            const token = document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content");

            const res = await fetch(url, {
                method: method,
                headers: {
                    "X-CSRF-TOKEN": token,
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    catatan_verifikasi: alasan,
                }),
            });

            const data = await res.json();

            if (data.success) {
                alert(data.message || "Berhasil.");
                if (window.reloadAjaxTable) window.reloadAjaxTable();
            } else {
                alert(data.message || "Gagal.");
            }
        } catch (err) {
            console.error("TOLAK DENDA ERROR:", err);
            alert("Terjadi kesalahan.");
        }
    });
}
