export function initAnggotaToast() {
    const toast = document.getElementById("toast");
    if (!toast) return;

    // Muncul (smooth zoom)
    setTimeout(() => {
        toast.classList.remove("scale-75", "opacity-0");
        toast.classList.add("scale-100", "opacity-100");
    }, 100);

    // Hilang (shrink + fade)
    setTimeout(() => {
        toast.classList.remove("scale-100", "opacity-100");
        toast.classList.add("scale-75", "opacity-0");
    }, 2500);
}
