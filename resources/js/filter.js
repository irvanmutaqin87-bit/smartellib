export function initFilter() {
    let filterOpen = false;

    window.toggleFilter = function () {
        const box = document.getElementById("filterBox");

        const icons = [
            document.getElementById("icon1"),
            document.getElementById("icon2"),
            document.getElementById("icon3"),
        ];

        if (!box) return;

        if (!filterOpen) {
            box.style.maxHeight = "700px";
            box.style.opacity = "1";

            icons.forEach((icon) => {
                if (icon) icon.classList.add("rotate-180");
            });
        } else {
            box.style.maxHeight = "0";
            box.style.opacity = "0";

            icons.forEach((icon) => {
                if (icon) icon.classList.remove("rotate-180");
            });
        }

        filterOpen = !filterOpen;
    };

    // =========================
    // SEARCH DALAM FILTER
    // =========================
    window.filterSearch = function (input, itemClass) {
        const keyword = input.value.toLowerCase();
        const items = document.querySelectorAll("." + itemClass);

        items.forEach((item) => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(keyword) ? "flex" : "none";
        });
    };
}
