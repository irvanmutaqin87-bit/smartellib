export function initNavbar() {
    const navIndicator = document.getElementById("navIndicator");
    const navLinks = document.querySelectorAll(".nav-link");

    if (navIndicator && navLinks.length) {
        function move(el) {
            navIndicator.style.width = el.offsetWidth + "px";
            navIndicator.style.left = el.offsetLeft + "px";
        }

        const active = document.querySelector(".nav-link.active");

        if (active) move(active);

        navLinks.forEach((link) => {
            link.addEventListener("mouseenter", () => move(link));

            link.addEventListener("mouseleave", () => {
                if (active) move(active);
            });
        });

        window.addEventListener("resize", () => {
            if (active) move(active);
        });
    }

    // =========================
    // SEARCH NAVIGATION
    // =========================

    window.goToSearch = function () {
        window.location.href = "/anggota/search";
    };

    window.goBack = function () {
        if (document.referrer) {
            window.history.back();
        } else {
            window.location.href = "/anggota/beranda";
        }
    };
}
