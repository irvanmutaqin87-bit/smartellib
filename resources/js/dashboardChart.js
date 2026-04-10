import Chart from "chart.js/auto";

let chartInstance = null;

// =========================
// INIT CHART
// =========================
export function initDashboardChart(labels, data) {
    const ctx = document.getElementById("peminjamanChart");

    if (!ctx) return;

    if (chartInstance) {
        chartInstance.destroy();
    }

    chartInstance = new Chart(ctx, {
        type: "line",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Peminjaman",
                    data: data,
                    tension: 0.4,
                    fill: true,
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
            },
        },
    });
}

// =========================
// INIT FILTER + ANIMATION
// =========================
export function initChartFilter() {
    const btn = document.getElementById("chartFilterBtn");
    const dropdown = document.getElementById("chartFilterDropdown");
    const options = document.querySelectorAll(".chartOption");
    const text = document.getElementById("chartFilterText");
    const icon = document.getElementById("chartFilterIcon");

    if (!btn || !dropdown) return;

    // =========================
    // TOGGLE DROPDOWN (SMOOTH)
    // =========================
    btn.addEventListener("click", () => {
        const isOpen = dropdown.classList.contains("opacity-100");

        if (isOpen) {
            // CLOSE
            dropdown.classList.remove(
                "opacity-100",
                "scale-100",
                "translate-y-0",
            );
            dropdown.classList.add(
                "opacity-0",
                "scale-[0.95]",
                "-translate-y-3",
                "pointer-events-none",
            );

            icon?.classList.remove("rotate-180");
        } else {
            // OPEN
            dropdown.classList.remove(
                "opacity-0",
                "scale-[0.95]",
                "-translate-y-3",
                "pointer-events-none",
            );
            dropdown.classList.add("opacity-100", "scale-100", "translate-y-0");

            icon?.classList.add("rotate-180");
        }
    });

    // =========================
    // CLICK LUAR (AUTO CLOSE)
    // =========================
    document.addEventListener("click", (e) => {
        if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.remove(
                "opacity-100",
                "scale-100",
                "translate-y-0",
            );
            dropdown.classList.add(
                "opacity-0",
                "scale-[0.95]",
                "-translate-y-3",
                "pointer-events-none",
            );

            icon?.classList.remove("rotate-180");
        }
    });

    // =========================
    // PILIH FILTER + UPDATE CHART
    // =========================
    options.forEach((opt) => {
        opt.addEventListener("click", () => {
            const value = opt.dataset.value;

            // update text
            text.innerText = opt.innerText;

            // tutup animasi
            dropdown.classList.remove(
                "opacity-100",
                "scale-100",
                "translate-y-0",
            );
            dropdown.classList.add(
                "opacity-0",
                "scale-[0.95]",
                "-translate-y-3",
                "pointer-events-none",
            );

            icon?.classList.remove("rotate-180");

            // fetch data baru
            fetch(`${window.location.pathname}?filter=${value}`, {
                headers: { "X-Requested-With": "XMLHttpRequest" },
            })
                .then((res) => res.json())
                .then((res) => {
                    initDashboardChart(res.labels, res.data);
                });
        });
    });
}
