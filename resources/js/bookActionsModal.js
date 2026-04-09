export function initBookActionsModal() {
    // =========================
    // SHARE MODAL
    // =========================
    const shareModal = document.getElementById("shareModal");
    const shareCard = document.getElementById("shareCard");
    const openShare = document.getElementById("openShareModal");
    const closeShare = document.getElementById("closeShareModal");

    // =========================
    // REPORT MODAL (kalau dipakai)
    // =========================
    const reportModal = document.getElementById("reportModal");
    const reportCard = document.getElementById("reportCard");
    const openReport = document.getElementById("openReportModal");
    const closeReport = document.getElementById("closeReportModal");

    // =========================
    // DENDA MODAL
    // =========================
    const dendaModal = document.getElementById("dendaModal");
    const dendaCard = document.getElementById("dendaCard");
    const openDenda = document.getElementById("openDendaModal");
    const closeDenda = document.getElementById("closeDendaModal");

    // =========================
    // REVIEW / ULASAN MODAL
    // =========================
    const reviewModal = document.getElementById("reviewModal");
    const reviewCard = document.getElementById("reviewCard");
    const openReview = document.getElementById("openUlasanModal");
    const closeReview = document.getElementById("closeReviewModal");

    // =========================
    // OPEN MODAL
    // =========================
    function open(modal, card, hiddenClasses = ["scale-90", "translate-y-6"]) {
        if (!modal || !card) return;

        modal.classList.remove("opacity-0", "pointer-events-none");

        requestAnimationFrame(() => {
            card.classList.remove("opacity-0", ...hiddenClasses);
            card.classList.add("opacity-100", "scale-100", "translate-y-0");
        });
    }

    // =========================
    // CLOSE MODAL
    // =========================
    function close(modal, card, hiddenClasses = ["scale-90", "translate-y-6"]) {
        if (!modal || !card) return;

        card.classList.remove("opacity-100", "scale-100", "translate-y-0");
        card.classList.add("opacity-0", ...hiddenClasses);

        setTimeout(() => {
            modal.classList.add("opacity-0", "pointer-events-none");
        }, 300);
    }

    // =========================
    // SHARE
    // =========================
    if (openShare) {
        openShare.addEventListener("click", () =>
            open(shareModal, shareCard, ["scale-90", "translate-y-6"]),
        );
    }

    if (closeShare) {
        closeShare.addEventListener("click", () =>
            close(shareModal, shareCard, ["scale-90", "translate-y-6"]),
        );
    }

    // klik backdrop untuk close
    if (shareModal) {
        shareModal.addEventListener("click", (e) => {
            if (e.target === shareModal) {
                close(shareModal, shareCard, ["scale-90", "translate-y-6"]);
            }
        });
    }

    // =========================
    // REPORT
    // =========================
    if (openReport) {
        openReport.addEventListener("click", () =>
            open(reportModal, reportCard, ["scale-90", "translate-y-6"]),
        );
    }

    if (closeReport) {
        closeReport.addEventListener("click", () =>
            close(reportModal, reportCard, ["scale-90", "translate-y-6"]),
        );
    }

    if (reportModal) {
        reportModal.addEventListener("click", (e) => {
            if (e.target === reportModal) {
                close(reportModal, reportCard, ["scale-90", "translate-y-6"]);
            }
        });
    }

    // =========================
    // DENDA
    // =========================
    if (openDenda) {
        openDenda.addEventListener("click", () =>
            open(dendaModal, dendaCard, ["scale-75", "translate-y-8"]),
        );
    }

    if (closeDenda) {
        closeDenda.addEventListener("click", () =>
            close(dendaModal, dendaCard, ["scale-75", "translate-y-8"]),
        );
    }

    if (dendaModal) {
        dendaModal.addEventListener("click", (e) => {
            if (e.target === dendaModal) {
                close(dendaModal, dendaCard, ["scale-75", "translate-y-8"]);
            }
        });
    }

    // =========================
    // REVIEW / ULASAN
    // =========================
    if (openReview) {
        openReview.addEventListener("click", () =>
            open(reviewModal, reviewCard, ["scale-75", "translate-y-8"]),
        );
    }

    if (closeReview) {
        closeReview.addEventListener("click", () =>
            close(reviewModal, reviewCard, ["scale-75", "translate-y-8"]),
        );
    }

    if (reviewModal) {
        reviewModal.addEventListener("click", (e) => {
            if (e.target === reviewModal) {
                close(reviewModal, reviewCard, ["scale-75", "translate-y-8"]);
            }
        });
    }

    // =========================
    // ESC KEY CLOSE
    // =========================
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            close(shareModal, shareCard, ["scale-90", "translate-y-6"]);
            close(reportModal, reportCard, ["scale-90", "translate-y-6"]);
            close(dendaModal, dendaCard, ["scale-75", "translate-y-8"]);
            close(reviewModal, reviewCard, ["scale-75", "translate-y-8"]);
        }
    });
}
