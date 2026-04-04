export function initTabs() {
    const tabs = document.querySelectorAll(".tab-link");
    const indicator = document.getElementById("tabIndicator");
    const content = document.getElementById("tabContent");

    if (!tabs.length) return;

    function move(el) {
        indicator.style.width = el.offsetWidth + "px";
        indicator.style.left = el.offsetLeft + "px";
    }

    window.switchTab = function (i) {
        content.style.transform = `translateX(-${i * 100}%)`;
        move(tabs[i]);
    };

    tabs.forEach((tab, i) => {
        tab.addEventListener("mouseenter", () => move(tab));
        tab.addEventListener("click", () => switchTab(i));
    });

    switchTab(0);
}
