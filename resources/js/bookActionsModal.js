export function initBookActionsModal() {
    const shareModal = document.getElementById("shareModal");
    const shareCard = document.getElementById("shareCard");
    const openShare = document.getElementById("openShareModal");
    const closeShare = document.getElementById("closeShareModal");

    const reportModal = document.getElementById("reportModal");
    const reportCard = document.getElementById("reportCard");
    const openReport = document.getElementById("openReportModal");
    const closeReport = document.getElementById("closeReportModal");

    function open(modal, card) {
        modal.classList.remove("opacity-0", "pointer-events-none");

        requestAnimationFrame(() => {
            card.classList.remove("opacity-0", "scale-90", "translate-y-6");
            card.classList.add("opacity-100", "scale-100", "translate-y-0");
        });
    }

    function close(modal, card) {
        card.classList.remove("opacity-100", "scale-100", "translate-y-0");
        card.classList.add("opacity-0", "scale-90", "translate-y-6");

        setTimeout(() => {
            modal.classList.add("opacity-0", "pointer-events-none");
        }, 300);
    }

    if (openShare) {
        openShare.addEventListener("click", () => open(shareModal, shareCard));
    }

    if (closeShare) {
        closeShare.addEventListener("click", () =>
            close(shareModal, shareCard),
        );
    }

    if (openReport) {
        openReport.addEventListener("click", () =>
            open(reportModal, reportCard),
        );
    }

    if (closeReport) {
        closeReport.addEventListener("click", () =>
            close(reportModal, reportCard),
        );
    }
}
