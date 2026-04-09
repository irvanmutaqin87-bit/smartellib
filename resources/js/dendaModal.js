export function initDendaModal() {
    const modal = document.getElementById("dendaModal");
    if (!modal) return;

    // =========================
    // COPY NOMOR PEMBAYARAN
    // =========================
    const copyButtons = document.querySelectorAll(".btn-copy-pembayaran");

    function showCopyToast(message = "Nomor pembayaran berhasil disalin") {
        const oldToast = document.getElementById("copyToast");
        if (oldToast) oldToast.remove();

        const toast = document.createElement("div");
        toast.id = "copyToast";
        toast.innerText = message;
        toast.className = `
            fixed top-6 right-6 z-[9999]
            bg-slate-900 text-white text-sm px-4 py-2.5
            rounded-full shadow-xl
            opacity-0 translate-y-2
            transition-all duration-300
        `;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.remove("opacity-0", "translate-y-2");
        }, 10);

        setTimeout(() => {
            toast.classList.add("opacity-0", "translate-y-2");
            setTimeout(() => toast.remove(), 300);
        }, 2200);
    }

    copyButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const nomor = this.dataset.nomor;
            if (!nomor) return;

            navigator.clipboard
                .writeText(nomor)
                .then(() => {
                    showCopyToast("Nomor pembayaran berhasil disalin");
                })
                .catch(() => {
                    showCopyToast("Gagal menyalin nomor pembayaran");
                });
        });
    });

    // =========================
    // CLOSE MODAL
    // =========================
    const closeBtn = document.getElementById("closeDendaModal");
    const closeFooterBtn = document.getElementById("closeDendaModalFooter");

    function closeModal() {
        modal.classList.add("opacity-0", "pointer-events-none");

        const card = document.getElementById("dendaCard");
        if (card) {
            card.classList.add("opacity-0", "scale-75", "translate-y-8");
            card.classList.remove("opacity-100", "scale-100", "translate-y-0");
        }
    }

    if (closeBtn) {
        closeBtn.addEventListener("click", closeModal);
    }

    if (closeFooterBtn) {
        closeFooterBtn.addEventListener("click", closeModal);
    }

    // klik backdrop untuk close
    modal.addEventListener("click", function (e) {
        if (e.target === modal) {
            closeModal();
        }
    });
}
