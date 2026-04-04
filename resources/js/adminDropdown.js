export function initAdminDropdown() {
    const profileBtn = document.getElementById("adminProfileBtn");
    const profileDropdown = document.getElementById("adminProfileDropdown");
    const icon = document.getElementById("adminProfileIcon");

    if (!profileBtn || !profileDropdown) return;

    let profileOpen = false;

    function open(drop) {
        drop.classList.remove("scale-y-0", "opacity-0", "-translate-y-3");

        drop.classList.add("scale-y-100", "opacity-100", "translate-y-0");

        // animasi icon
        icon.classList.add("rotate-180", "scale-110");
    }

    function close(drop) {
        drop.classList.remove("scale-y-100", "opacity-100", "translate-y-0");

        drop.classList.add("scale-y-0", "opacity-0", "-translate-y-3");

        // reset icon
        icon.classList.remove("rotate-180", "scale-110");
    }

    profileBtn.addEventListener("click", (e) => {
        e.stopPropagation();

        if (!profileOpen) {
            open(profileDropdown);
            profileOpen = true;
        } else {
            close(profileDropdown);
            profileOpen = false;
        }
    });

    document.addEventListener("click", () => {
        close(profileDropdown);
        profileOpen = false;
    });
}
