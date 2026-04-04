export function initToast() {
    const toast = document.querySelector(".animate-fade-in");

    if (!toast) return;

    setTimeout(() => {
        toast.style.transition = "opacity 0.3s ease, transform 0.3s ease";
        toast.style.opacity = "0";
        toast.style.transform = "translateY(-10px)";

        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 3000);
}
