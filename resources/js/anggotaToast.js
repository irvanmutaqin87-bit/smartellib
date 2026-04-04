export function initAnggotaToast() {
    // =========================
    // TOAST STATIS DARI BLADE
    // =========================
    const toast = document.getElementById("toast");

    if (toast) {
        setTimeout(() => {
            toast.classList.remove("scale-75", "opacity-0");
            toast.classList.add("scale-100", "opacity-100");
        }, 100);

        setTimeout(() => {
            toast.classList.remove("scale-100", "opacity-100");
            toast.classList.add("scale-75", "opacity-0");

            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 2500);
    }

    // =========================
    // TOAST DINAMIS UNTUK AJAX / JSON
    // =========================
    if (!window.showAnggotaToast) {
        window.showAnggotaToast = function (message, type = "success") {
            const toast = document.createElement("div");

            const bgClass =
                type === "success"
                    ? "bg-emerald-500"
                    : type === "error"
                      ? "bg-red-500"
                      : "bg-slate-700";

            toast.className = `
                fixed top-6 right-6 z-[9999]
                px-5 py-3 rounded-2xl shadow-2xl text-white text-sm font-medium
                ${bgClass}
                opacity-0 translate-y-3 scale-95 transition-all duration-300
            `;

            toast.innerText = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove(
                    "opacity-0",
                    "translate-y-3",
                    "scale-95",
                );
                toast.classList.add(
                    "opacity-100",
                    "translate-y-0",
                    "scale-100",
                );
            }, 50);

            setTimeout(() => {
                toast.classList.remove(
                    "opacity-100",
                    "translate-y-0",
                    "scale-100",
                );
                toast.classList.add("opacity-0", "translate-y-3", "scale-95");

                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 2500);
        };
    }
}
