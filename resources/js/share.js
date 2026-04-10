export function initShare() {
    const openBtn = document.getElementById("openShareModal");
    const closeBtn = document.getElementById("closeShareModal");
    const modal = document.getElementById("shareModal");
    const card = document.getElementById("shareCard");

    const copyBtn = document.getElementById("copyBookLink");
    const shareWA = document.getElementById("shareWA");
    const shareFB = document.getElementById("shareFB");
    const shareTG = document.getElementById("shareTG");
    const shareTW = document.getElementById("shareTW");

    if (!modal) return;

    const url = window.location.href;
    const text = "Lihat buku ini di SMARTELLIB 📚";

    // =========================
    // OPEN MODAL
    // =========================
    openBtn?.addEventListener("click", () => {
        modal.classList.remove("opacity-0", "pointer-events-none");

        setTimeout(() => {
            card.classList.remove("opacity-0", "scale-90", "translate-y-6");
        }, 50);
    });

    // =========================
    // CLOSE MODAL
    // =========================
    function closeModal() {
        card.classList.add("opacity-0", "scale-90", "translate-y-6");

        setTimeout(() => {
            modal.classList.add("opacity-0", "pointer-events-none");
        }, 200);
    }

    closeBtn?.addEventListener("click", closeModal);

    modal.addEventListener("click", (e) => {
        if (e.target === modal) closeModal();
    });

    // =========================
    // COPY LINK
    // =========================
    copyBtn?.addEventListener("click", async () => {
        try {
            await navigator.clipboard.writeText(url);

            copyBtn.innerText = "Link Tersalin";

            setTimeout(() => {
                copyBtn.innerText = "Salin Link";
            }, 2000);
        } catch (err) {
            alert("Gagal menyalin link");
        }
    });

    // =========================
    // SHARE LINKS
    // =========================
    shareWA.href = `https://wa.me/?text=${encodeURIComponent(text + " " + url)}`;

    shareFB.href = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;

    shareTG.href = `https://t.me/share/url?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}`;

    shareTW.href = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`;
}
