export function initDropdown() {
    const notifBtn = document.getElementById("notifBtn");
    const notifDropdown = document.getElementById("notifDropdown");

    const profileBtn = document.getElementById("profileBtn");
    const profileDropdown = document.getElementById("profileDropdown");

    const bookMenuBtn = document.getElementById("bookMenuButton");
    const bookDropdown = document.getElementById("bookDropdown");

    const statusFilterBtn = document.getElementById("statusFilterBtn");
    const statusFilterDropdown = document.getElementById(
        "statusFilterDropdown",
    );
    const statusFilterText = document.getElementById("statusFilterText");
    const statusFilterIcon = document.getElementById("statusFilterIcon");

    const kategoriFilterBtn = document.getElementById("kategoriFilterBtn");
    const kategoriFilterDropdown = document.getElementById(
        "kategoriFilterDropdown",
    );
    const kategoriFilterText = document.getElementById("kategoriFilterText");
    const kategoriFilterIcon = document.getElementById("kategoriFilterIcon");

    // hidden input / real input (FILTER LAMA)
    const statusInput = document.getElementById("statusFilter");
    const kategoriInput = document.getElementById("kategoriFilter");

    // =========================
    // DROPDOWN KHUSUS PETUGAS (BARU)
    // =========================
    const petugasStatusBtn = document.getElementById("petugasStatusBtn");
    const petugasStatusDropdown = document.getElementById(
        "petugasStatusDropdown",
    );
    const petugasStatusText = document.getElementById("petugasStatusText");
    const petugasStatusIcon = document.getElementById("petugasStatusIcon");
    const petugasStatusInput = document.getElementById("petugasStatusInput");
    const petugasStatusOptions = document.querySelectorAll(
        ".petugasStatusOption",
    );

    // =========================
    // DROPDOWN KHUSUS PENGATURAN SISTEM
    // METODE PEMBAYARAN DENDA
    // =========================
    const metodePembayaranBtn = document.getElementById("metodePembayaranBtn");
    const metodePembayaranDropdown = document.getElementById(
        "metodePembayaranDropdown",
    );
    const metodePembayaranText = document.getElementById(
        "metodePembayaranText",
    );
    const metodePembayaranIcon = document.getElementById(
        "metodePembayaranIcon",
    );
    const metodePembayaranInput = document.getElementById(
        "metodePembayaranInput",
    );

    // =========================
    // UTILITY
    // =========================
    function open(drop) {
        if (!drop) return;

        drop.classList.remove(
            "scale-y-95",
            "opacity-0",
            "-translate-y-2",
            "pointer-events-none",
        );

        drop.classList.add("scale-y-100", "opacity-100", "translate-y-0");
    }

    function close(drop) {
        if (!drop) return;

        drop.classList.remove("scale-y-100", "opacity-100", "translate-y-0");

        drop.classList.add(
            "scale-y-95",
            "opacity-0",
            "-translate-y-2",
            "pointer-events-none",
        );
    }

    function isOpen(drop) {
        return drop?.classList.contains("scale-y-100");
    }

    function closeBookActionDropdowns(except = null) {
        document.querySelectorAll(".bookActionDropdown").forEach((drop) => {
            if (drop === except) return;

            drop.classList.remove(
                "scale-100",
                "opacity-100",
                "translate-x-0",
                "pointer-events-auto",
            );

            drop.classList.add(
                "scale-95",
                "opacity-0",
                "translate-x-2",
                "pointer-events-none",
            );
        });
    }

    function closeAll(exceptDropdown = null) {
        if (notifDropdown !== exceptDropdown) close(notifDropdown);
        if (profileDropdown !== exceptDropdown) close(profileDropdown);
        if (bookDropdown !== exceptDropdown) close(bookDropdown);
        if (statusFilterDropdown !== exceptDropdown)
            close(statusFilterDropdown);
        if (kategoriFilterDropdown !== exceptDropdown)
            close(kategoriFilterDropdown);

        // KHUSUS PETUGAS
        if (petugasStatusDropdown !== exceptDropdown)
            close(petugasStatusDropdown);

        // KHUSUS PENGATURAN SISTEM
        if (metodePembayaranDropdown !== exceptDropdown)
            close(metodePembayaranDropdown);

        closeBookActionDropdowns(exceptDropdown);

        if (exceptDropdown !== statusFilterDropdown) {
            statusFilterIcon?.classList.remove("rotate-180");
        }

        if (exceptDropdown !== kategoriFilterDropdown) {
            kategoriFilterIcon?.classList.remove("rotate-180");
        }

        // KHUSUS PETUGAS
        if (exceptDropdown !== petugasStatusDropdown) {
            petugasStatusIcon?.classList.remove("rotate-180");
        }

        // KHUSUS PENGATURAN SISTEM
        if (exceptDropdown !== metodePembayaranDropdown) {
            metodePembayaranIcon?.classList.remove("rotate-180");
        }
    }

    // =========================
    // MAIN DROPDOWNS
    // =========================
    notifBtn?.addEventListener("click", (e) => {
        e.stopPropagation();
        if (isOpen(notifDropdown)) {
            close(notifDropdown);
        } else {
            closeAll(notifDropdown);
            open(notifDropdown);
        }
    });

    profileBtn?.addEventListener("click", (e) => {
        e.stopPropagation();
        if (isOpen(profileDropdown)) {
            close(profileDropdown);
        } else {
            closeAll(profileDropdown);
            open(profileDropdown);
        }
    });

    bookMenuBtn?.addEventListener("click", (e) => {
        e.stopPropagation();
        if (isOpen(bookDropdown)) {
            close(bookDropdown);
        } else {
            closeAll(bookDropdown);
            open(bookDropdown);
        }
    });

    statusFilterBtn?.addEventListener("click", (e) => {
        e.stopPropagation();
        if (isOpen(statusFilterDropdown)) {
            close(statusFilterDropdown);
            statusFilterIcon?.classList.remove("rotate-180");
        } else {
            closeAll(statusFilterDropdown);
            open(statusFilterDropdown);
            statusFilterIcon?.classList.add("rotate-180");
        }
    });

    kategoriFilterBtn?.addEventListener("click", (e) => {
        e.stopPropagation();
        if (isOpen(kategoriFilterDropdown)) {
            close(kategoriFilterDropdown);
            kategoriFilterIcon?.classList.remove("rotate-180");
        } else {
            closeAll(kategoriFilterDropdown);
            open(kategoriFilterDropdown);
            kategoriFilterIcon?.classList.add("rotate-180");
        }
    });

    // =========================
    // DROPDOWN STATUS PETUGAS (BARU)
    // =========================
    petugasStatusBtn?.addEventListener("click", (e) => {
        e.stopPropagation();
        if (isOpen(petugasStatusDropdown)) {
            close(petugasStatusDropdown);
            petugasStatusIcon?.classList.remove("rotate-180");
        } else {
            closeAll(petugasStatusDropdown);
            open(petugasStatusDropdown);
            petugasStatusIcon?.classList.add("rotate-180");
        }
    });

    // =========================
    // DROPDOWN METODE PEMBAYARAN (BARU)
    // =========================
    metodePembayaranBtn?.addEventListener("click", (e) => {
        e.stopPropagation();
        if (isOpen(metodePembayaranDropdown)) {
            close(metodePembayaranDropdown);
            metodePembayaranIcon?.classList.remove("rotate-180");
        } else {
            closeAll(metodePembayaranDropdown);
            open(metodePembayaranDropdown);
            metodePembayaranIcon?.classList.add("rotate-180");
        }
    });

    // =========================
    // OPTION FILTER LAMA
    // =========================
    document.addEventListener("click", function (e) {
        const statusOption = e.target.closest(".statusOption");
        if (statusOption) {
            e.stopPropagation();

            const text = statusOption.innerText.trim();
            const value = statusOption.dataset.value ?? "";

            if (statusFilterText) {
                statusFilterText.innerText = text;
            }

            if (statusInput) {
                statusInput.value = value;
                statusInput.dispatchEvent(
                    new Event("change", { bubbles: true }),
                );
            }

            close(statusFilterDropdown);
            statusFilterIcon?.classList.remove("rotate-180");
            return;
        }
    });

    // =========================
    // OPTION KHUSUS PETUGAS (FIX BUG)
    // =========================
    petugasStatusOptions.forEach((option) => {
        option.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();

            const text = this.innerText.trim();
            const value = this.dataset.value ?? "";

            if (petugasStatusText) {
                petugasStatusText.innerText = text;
            }

            if (petugasStatusInput) {
                petugasStatusInput.value = value;
                petugasStatusInput.dispatchEvent(
                    new Event("change", { bubbles: true }),
                );
            }

            close(petugasStatusDropdown);
            petugasStatusIcon?.classList.remove("rotate-180");
        });
    });

    // =========================
    // OPTION METODE PEMBAYARAN (BARU)
    // =========================
    document.querySelectorAll(".metodePembayaranOption").forEach((option) => {
        option.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();

            const text = this.innerText.trim();
            const value = this.dataset.value ?? "";

            if (metodePembayaranText) {
                metodePembayaranText.innerText = text;
            }

            if (metodePembayaranInput) {
                metodePembayaranInput.value = value;
                metodePembayaranInput.dispatchEvent(
                    new Event("change", { bubbles: true }),
                );
                metodePembayaranInput.dispatchEvent(
                    new Event("input", { bubbles: true }),
                );
            }

            close(metodePembayaranDropdown);
            metodePembayaranIcon?.classList.remove("rotate-180");
        });
    });

    // =========================
    // BOOK ACTION DROPDOWN
    // =========================
    document.addEventListener("click", function (e) {
        const btn = e.target.closest(".bookActionBtn");

        if (btn) {
            const dropdown = btn.nextElementSibling;
            if (!dropdown) return;

            const isDropdownOpen = dropdown.classList.contains("scale-100");

            closeBookActionDropdowns();

            if (!isDropdownOpen) {
                dropdown.classList.remove(
                    "scale-95",
                    "opacity-0",
                    "translate-x-2",
                    "pointer-events-none",
                );

                dropdown.classList.add(
                    "scale-100",
                    "opacity-100",
                    "translate-x-0",
                    "pointer-events-auto",
                );
            }

            return;
        }

        if (e.target.closest(".bookActionDropdown")) return;

        closeBookActionDropdowns();
    });

    // =========================
    // NOTIF CARD DROPDOWN
    // =========================
    document.addEventListener("click", function (e) {
        const btn = e.target.closest(".notifMenuButton");

        if (btn) {
            const dropdown = btn.nextElementSibling;
            if (!dropdown) return;

            const isNotifOpen = dropdown.classList.contains("scale-y-100");

            document.querySelectorAll(".notifDropdown").forEach((d) => {
                d.classList.remove(
                    "scale-y-100",
                    "opacity-100",
                    "translate-y-0",
                );

                d.classList.add("scale-y-0", "opacity-0", "-translate-y-2");
            });

            if (!isNotifOpen) {
                dropdown.classList.remove(
                    "scale-y-0",
                    "opacity-0",
                    "-translate-y-2",
                );

                dropdown.classList.add(
                    "scale-y-100",
                    "opacity-100",
                    "translate-y-0",
                );
            }

            return;
        }

        if (e.target.closest(".notifDropdown")) return;
    });

    // =========================
    // CLICK OUTSIDE GLOBAL
    // =========================
    document.addEventListener("click", function (e) {
        if (e.target.closest(".bookActionBtn")) return;
        if (e.target.closest(".bookActionDropdown")) return;
        if (e.target.closest(".notifMenuButton")) return;
        if (e.target.closest(".notifDropdown")) return;

        closeAll();
    });

    // =========================
    // PREVENT CLOSE INSIDE
    // =========================
    [
        notifDropdown,
        profileDropdown,
        bookDropdown,
        statusFilterDropdown,
        kategoriFilterDropdown,
        petugasStatusDropdown,
        metodePembayaranDropdown,
    ].forEach((el) => {
        el?.addEventListener("click", (e) => e.stopPropagation());
    });

    // =========================
    // SET DEFAULT VALUE SAAT LOAD (KHUSUS PETUGAS)
    // =========================
    if (petugasStatusInput && petugasStatusText) {
        const currentValue = petugasStatusInput.value?.trim().toLowerCase();

        if (currentValue === "aktif") {
            petugasStatusText.innerText = "Aktif";
        } else if (currentValue === "nonaktif") {
            petugasStatusText.innerText = "Nonaktif";
        } else {
            petugasStatusText.innerText = "Pilih Status Akun";
        }
    }

    // =========================
    // SET DEFAULT VALUE SAAT LOAD
    // KHUSUS METODE PEMBAYARAN
    // =========================
    if (metodePembayaranInput && metodePembayaranText) {
        const currentValue = metodePembayaranInput.value?.trim();

        if (currentValue) {
            metodePembayaranText.innerText = currentValue;
        } else {
            metodePembayaranText.innerText = "Pilih Metode Pembayaran";
        }
    }
}
