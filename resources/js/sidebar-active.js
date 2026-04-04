export function initSidebarActive() {
    const links = document.querySelectorAll(".sidebar-link");
    const currentPath = window.location.pathname;

    if (!links.length) return;

    links.forEach((link) => {
        const href = link.getAttribute("href");

        // Base style semua menu
        link.classList.remove(
            "bg-white",
            "text-cyan-600",
            "font-semibold",
            "shadow-sm",
            "scale-[1.02]",
        );

        link.classList.add(
            "text-white",
            "hover:bg-white/30",
            "transition-all",
            "duration-500",
            "ease-in-out",
        );

        if (!href || href === "#") return;

        try {
            const linkPath = new URL(href, window.location.origin).pathname;

            if (
                currentPath === linkPath ||
                (linkPath !== "/" && currentPath.startsWith(linkPath))
            ) {
                link.classList.remove("text-white", "hover:bg-white/30");

                // Delay kecil biar munculnya lebih smooth
                requestAnimationFrame(() => {
                    link.classList.add(
                        "bg-white",
                        "text-cyan-600",
                        "font-semibold",
                        "shadow-sm",
                        "scale-[1.02]",
                    );
                });
            }
        } catch (error) {
            console.error("Sidebar link error:", error);
        }
    });
}
