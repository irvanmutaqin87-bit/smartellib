export function initPasswordModal() {
    const modal = document.getElementById("passwordModal");
    const card = document.getElementById("passwordCard");
    const openBtn = document.getElementById("openPasswordModal");
    const closeBtn = document.getElementById("closePasswordModal");

    if (!modal || !card || !openBtn) return;

    function openModal() {
        // tampilkan overlay
        modal.classList.remove("opacity-0", "pointer-events-none");

        requestAnimationFrame(() => {
            card.classList.remove("opacity-0", "scale-90", "translate-y-6");

            card.classList.add("opacity-100", "scale-100", "translate-y-0");
        });
    }

    function closeModal() {
        card.classList.remove("opacity-100", "scale-100", "translate-y-0");

        card.classList.add("opacity-0", "scale-90", "translate-y-6");

        setTimeout(() => {
            modal.classList.add("opacity-0", "pointer-events-none");
        }, 300);
    }

    openBtn.addEventListener("click", openModal);

    if (closeBtn) {
        closeBtn.addEventListener("click", closeModal);
    }

    modal.addEventListener("click", function (e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            closeModal();
        }
    });
}
