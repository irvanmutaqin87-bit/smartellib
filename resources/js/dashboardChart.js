import Chart from "chart.js/auto";

let chartInstance = null;

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

export function initChartFilter() {
    const options = document.querySelectorAll(".chartOption");
    const text = document.getElementById("chartFilterText");

    options.forEach((btn) => {
        btn.addEventListener("click", () => {
            const value = btn.dataset.value;
            text.innerText = btn.innerText;

            fetch(`/admin/dashboard?filter=${value}`, {
                headers: { "X-Requested-With": "XMLHttpRequest" },
            })
                .then((res) => res.json())
                .then((res) => {
                    // update chart TANPA reload
                    initDashboardChart(res.labels, res.data);
                });
        });
    });
}
