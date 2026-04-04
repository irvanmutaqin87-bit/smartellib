export function initDescriptionToggle() {
    const text = document.getElementById("descText");
    const btn = document.getElementById("descBtn");

    if (!text || !btn) return;

    let open = false;

    text.style.overflow = "hidden";
    text.style.maxHeight = "3.6em";
    text.style.transition = "max-height .7s cubic-bezier(.22,1,.36,1)";

    btn.addEventListener("click", () => {
        if (!open) {
            // HAPUS clamp supaya teks bisa terbuka
            text.classList.remove("line-clamp-2");

            const fullHeight = text.scrollHeight;

            text.style.maxHeight = fullHeight + "px";

            btn.innerText = "Baca lebih sedikit";

            open = true;
        } else {
            text.style.maxHeight = "3.6em";

            btn.innerText = "Selengkapnya";

            open = false;

            // setelah animasi selesai, clamp lagi
            setTimeout(() => {
                text.classList.add("line-clamp-2");
            }, 700);
        }
    });
}
