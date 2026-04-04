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
        const keyword = input.value.toLowerCase().trim();
        const items = document.querySelectorAll("." + itemClass);

        items.forEach((item) => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(keyword) ? "flex" : "none";
        });
    };

    // =========================
    // LOAD MORE FILTER ITEM
    // =========================
    window.loadMore = function (itemClass, button, step = 8) {
        const items = document.querySelectorAll("." + itemClass);
        let hiddenItems = Array.from(items).filter(
            (item) => item.dataset.shown !== "true",
        );

        hiddenItems.slice(0, step).forEach((item) => {
            item.style.display = "flex";
            item.dataset.shown = "true";
        });

        hiddenItems = Array.from(items).filter(
            (item) => item.dataset.shown !== "true",
        );

        if (hiddenItems.length === 0 && button) {
            button.style.display = "none";
        }
    };

    // =========================
    // INIT FILTER ITEM LIMIT
    // =========================
    ["kategori-item", "author-item", "year-item"].forEach((className) => {
        const items = document.querySelectorAll("." + className);

        items.forEach((item, index) => {
            if (index < 8) {
                item.style.display = "flex";
                item.dataset.shown = "true";
            } else {
                item.style.display = "none";
                item.dataset.shown = "false";
            }
        });
    });
}
