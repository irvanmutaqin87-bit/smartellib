export function initAjaxTable({
    url,
    tableContainer,
    paginationContainer,
    searchInput = null,
    filterInput = null,
    filterInputs = [],
    autoRefresh = false,
    refreshInterval = 3000,
    extraTargets = {}, // tambahan universal
}) {
    const tableEl = tableContainer
        ? document.querySelector(tableContainer)
        : null;
    const paginationEl = paginationContainer
        ? document.querySelector(paginationContainer)
        : null;
    const searchEl = searchInput ? document.querySelector(searchInput) : null;

    const allFilterSelectors = [
        ...(filterInput ? [filterInput] : []),
        ...(Array.isArray(filterInputs) ? filterInputs : []),
    ];

    const allFilterEls = allFilterSelectors
        .map((selector) => document.querySelector(selector))
        .filter(Boolean);

    if (!tableEl || !paginationEl) return;

    let currentPageUrl = url;
    let debounceTimeout = null;
    let autoRefreshTimer = null;
    let isLoading = false;

    // =========================
    // BUILD REQUEST URL
    // =========================
    function buildRequestUrl(pageUrl = currentPageUrl) {
        const baseUrl = pageUrl.split("?")[0];
        const urlObj = new URL(pageUrl, window.location.origin);
        const params = new URLSearchParams(urlObj.search);

        const currentPage = urlObj.searchParams.get("page");

        params.delete("search");
        params.delete("page");

        allFilterEls.forEach((filterEl) => {
            const key = filterEl.name || filterEl.id;
            if (key) params.delete(key);
        });

        if (currentPage) {
            params.set("page", currentPage);
        }

        if (searchEl && searchEl.value.trim() !== "") {
            params.set("search", searchEl.value.trim());
        }

        allFilterEls.forEach((filterEl) => {
            const key = filterEl.name || filterEl.id;
            const value = filterEl.value?.trim?.() ?? filterEl.value;

            if (key && value !== "") {
                params.set(key, value);
            }
        });

        return `${baseUrl}?${params.toString()}`;
    }

    // =========================
    // UPDATE EXTRA TARGETS
    // =========================
    function updateExtraTargets(data) {
        Object.keys(extraTargets).forEach((responseKey) => {
            const selector = extraTargets[responseKey];
            const targetEl = document.querySelector(selector);

            if (targetEl && data[responseKey] !== undefined) {
                targetEl.innerHTML = data[responseKey];
            }
        });
    }

    // =========================
    // LOAD DATA AJAX
    // =========================
    function loadData(pageUrl = currentPageUrl, silent = false) {
        if (isLoading) return;

        isLoading = true;
        currentPageUrl = pageUrl;

        const requestUrl = buildRequestUrl(pageUrl);

        if (!silent) {
            tableEl.style.opacity = "0.55";
            paginationEl.style.opacity = "0.55";
            tableEl.style.transition = "all .25s ease";
            paginationEl.style.transition = "all .25s ease";
        }

        fetch(requestUrl, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
            },
            cache: "no-store",
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.table) {
                    tableEl.innerHTML = data.table;
                }

                if (paginationEl) {
                    paginationEl.innerHTML = data.pagination || "";
                }

                //  update target tambahan
                updateExtraTargets(data);

                tableEl.style.opacity = "1";
                paginationEl.style.opacity = "1";
            })
            .catch((err) => {
                console.error("AJAX TABLE ERROR:", err);
                tableEl.style.opacity = "1";
                paginationEl.style.opacity = "1";
            })
            .finally(() => {
                isLoading = false;
            });
    }

    // =========================
    // GLOBAL RELOAD
    // =========================
    window.reloadAjaxTable = function () {
        loadData(currentPageUrl);
    };

    window.refreshAjaxTableSilently = function () {
        loadData(currentPageUrl, true);
    };

    // =========================
    // SEARCH REALTIME
    // =========================
    if (searchEl) {
        searchEl.addEventListener("input", () => {
            clearTimeout(debounceTimeout);

            debounceTimeout = setTimeout(() => {
                loadData(url);
            }, 400);
        });
    }

    // =========================
    // FILTER LISTENER
    // =========================
    allFilterEls.forEach((filterEl) => {
        filterEl.addEventListener("change", () => {
            loadData(url);
        });
    });

    // =========================
    // PAGINATION AJAX
    // =========================
    document.addEventListener("click", function (e) {
        const link = e.target.closest(".pagination-link, .pagination a");
        if (!link) return;

        if (!paginationEl.contains(link)) return;

        e.preventDefault();

        const targetUrl = link.getAttribute("href");
        if (targetUrl) {
            loadData(targetUrl);
        }
    });

    // =========================
    // AUTO REFRESH
    // =========================
    if (autoRefresh) {
        autoRefreshTimer = setInterval(() => {
            loadData(currentPageUrl, true);
        }, refreshInterval);
    }

    return {
        reload: () => loadData(currentPageUrl),
        refresh: () => loadData(currentPageUrl, true),
        destroy: () => {
            clearTimeout(debounceTimeout);
            clearInterval(autoRefreshTimer);
        },
    };
}

// =========================
// 🔄 REALTIME SYNC KATEGORI
// Universal untuk:
// - Index Buku
// - Create Buku
// - Edit Buku
// =========================
export function initRealtimeKategoriDropdown() {
    console.log("MEMANGGIL REALTIME KATEGORI");

    const kategoriFilterDropdown = document.getElementById(
        "kategoriFilterDropdown",
    );
    const kategoriFilterText = document.getElementById("kategoriFilterText");
    const kategoriFilterInput = document.getElementById("kategoriFilter");

    if (
        !kategoriFilterDropdown &&
        !kategoriFilterInput &&
        !kategoriFilterText
    ) {
        return;
    }

    let lastServerUpdate = "0";

    // =========================
    // RENDER CUSTOM DROPDOWN
    // =========================
    function renderCustomDropdown(kategoriList) {
        if (!kategoriFilterDropdown || !kategoriFilterInput) return;

        const currentSelectedId = kategoriFilterInput.value || "";
        const isIndexPage = window.location.pathname.endsWith("/buku");

        let html = "";

        if (isIndexPage) {
            html += `
                <button type="button"
                    class="kategoriOption w-full text-left px-4 py-2.5 rounded-xl hover:bg-slate-100 text-sm text-slate-700 transition"
                    data-id=""
                    data-name="Semua Kategori">
                    Semua Kategori
                </button>
            `;
        }

        kategoriList.forEach((item) => {
            html += `
                <button type="button"
                    class="kategoriOption w-full text-left px-4 py-2.5 rounded-xl
                    ${isIndexPage ? "hover:bg-slate-100" : "hover:bg-cyan-50 hover:text-cyan-800"}
                    text-sm text-slate-700 transition"
                    data-id="${item.id}"
                    data-name="${item.nama_kategori}">
                    ${item.nama_kategori}
                </button>
            `;
        });

        kategoriFilterDropdown.innerHTML = html;

        // =========================
        // SET TEXT SELECTED
        // =========================
        const selectedKategori = kategoriList.find(
            (item) => String(item.id) === String(currentSelectedId),
        );

        if (selectedKategori && kategoriFilterText) {
            kategoriFilterText.innerText = selectedKategori.nama_kategori;
        } else {
            if (kategoriFilterText) {
                kategoriFilterText.innerText = isIndexPage
                    ? "Semua Kategori"
                    : "Pilih Kategori";
            }
        }

        bindKategoriOptionEvents();
    }

    // =========================
    // BIND CLICK OPTION
    // =========================
    function bindKategoriOptionEvents() {
        const options = document.querySelectorAll(".kategoriOption");

        options.forEach((option) => {
            option.addEventListener("click", function () {
                const selectedId = this.dataset.id || "";
                const selectedName = this.dataset.name || "Pilih Kategori";

                if (kategoriFilterInput) {
                    kategoriFilterInput.value = selectedId;
                    kategoriFilterInput.dispatchEvent(
                        new Event("change", { bubbles: true }),
                    );
                    kategoriFilterInput.dispatchEvent(
                        new Event("input", { bubbles: true }),
                    );
                }

                if (kategoriFilterText) {
                    kategoriFilterText.innerText = selectedName;
                }

                if (kategoriFilterDropdown) {
                    kategoriFilterDropdown.classList.add(
                        "opacity-0",
                        "translate-y-[-12px]",
                        "scale-[0.98]",
                        "pointer-events-none",
                    );
                    kategoriFilterDropdown.classList.remove(
                        "opacity-100",
                        "translate-y-0",
                        "scale-100",
                        "pointer-events-auto",
                    );
                }
            });
        });
    }

    // =========================
    // FETCH KATEGORI TERBARU
    // =========================
    async function fetchLatestKategori(forceRender = false) {
        try {
            const currentPath = window.location.pathname;
            const rolePrefix = currentPath.startsWith("/admin")
                ? "admin"
                : "petugas";

            const res = await fetch(`/${rolePrefix}/kategori/list/ajax`, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                },
                cache: "no-store",
            });

            if (!res.ok) {
                throw new Error(`HTTP ${res.status}`);
            }

            const data = await res.json();

            console.log("DATA KATEGORI AJAX:", data);

            const serverUpdatedAt = String(data.updated_at || "0");

            console.log(
                "CEK SERVER UPDATE:",
                serverUpdatedAt,
                "LAST:",
                lastServerUpdate,
            );

            if (forceRender || serverUpdatedAt !== lastServerUpdate) {
                console.log("TERDETEKSI UPDATE KATEGORI!");
                lastServerUpdate = serverUpdatedAt;

                if (data.success && Array.isArray(data.kategori)) {
                    renderCustomDropdown(data.kategori);
                }
            }
        } catch (err) {
            console.error("REALTIME KATEGORI ERROR:", err);
        }
    }

    // =========================
    // STORAGE LISTENER (opsional, bonus)
    // =========================
    window.addEventListener("storage", (e) => {
        if (e.key === "kategori_updated_at") {
            console.log("STORAGE UPDATE TERDETEKSI");
            fetchLatestKategori(true);
        }
    });

    // =========================
    // POLLING SERVER (inti realtime asli)
    // =========================
    setInterval(() => {
        fetchLatestKategori(false);
    }, 5000);

    // =========================
    // FETCH AWAL
    // =========================
    fetchLatestKategori(true);
}

// =========================
// 🎯 UNIVERSAL CUSTOM FILTER DROPDOWN
// Bisa dipakai untuk:
// - Status
// - Kategori
// - Jenis
// - Role
// - Laporan
// =========================
export function initCustomAjaxFilterDropdown({
    buttonId,
    dropdownId,
    textId,
    inputId,
    optionClass,
    defaultText = "Pilih Filter",
    useDataValue = true,
}) {
    const button = document.getElementById(buttonId);
    const dropdown = document.getElementById(dropdownId);
    const text = document.getElementById(textId);
    const input = document.getElementById(inputId);

    if (!button || !dropdown || !text || !input) return;

    const icon = button.querySelector("svg");

    // TOGGLE DROPDOWN
    button.addEventListener("click", function (e) {
        e.stopPropagation();

        const isOpen = dropdown.classList.contains("opacity-100");

        if (isOpen) {
            dropdown.classList.add(
                "opacity-0",
                "translate-y-[-12px]",
                "scale-[0.98]",
                "pointer-events-none",
            );
            dropdown.classList.remove(
                "opacity-100",
                "translate-y-0",
                "scale-100",
                "pointer-events-auto",
            );

            if (icon) icon.classList.remove("rotate-180");
        } else {
            dropdown.classList.remove(
                "opacity-0",
                "translate-y-[-12px]",
                "scale-[0.98]",
                "pointer-events-none",
            );
            dropdown.classList.add(
                "opacity-100",
                "translate-y-0",
                "scale-100",
                "pointer-events-auto",
            );

            if (icon) icon.classList.add("rotate-180");
        }
    });

    // CLICK OPTION
    dropdown.querySelectorAll(`.${optionClass}`).forEach((option) => {
        option.addEventListener("click", function () {
            const selectedText = this.innerText.trim();

            let selectedValue = "";

            if (useDataValue) {
                selectedValue = this.dataset.value ?? "";
            } else {
                selectedValue =
                    selectedText.toLowerCase() === defaultText.toLowerCase()
                        ? ""
                        : selectedText.toLowerCase();
            }

            input.value = selectedValue;
            input.dispatchEvent(new Event("change", { bubbles: true }));
            input.dispatchEvent(new Event("input", { bubbles: true }));

            text.innerText = selectedText;

            dropdown.classList.add(
                "opacity-0",
                "translate-y-[-12px]",
                "scale-[0.98]",
                "pointer-events-none",
            );
            dropdown.classList.remove(
                "opacity-100",
                "translate-y-0",
                "scale-100",
                "pointer-events-auto",
            );

            if (icon) icon.classList.remove("rotate-180");
        });
    });

    // CLOSE OUTSIDE
    document.addEventListener("click", function (e) {
        if (!button.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add(
                "opacity-0",
                "translate-y-[-12px]",
                "scale-[0.98]",
                "pointer-events-none",
            );
            dropdown.classList.remove(
                "opacity-100",
                "translate-y-0",
                "scale-100",
                "pointer-events-auto",
            );

            if (icon) icon.classList.remove("rotate-180");
        }
    });
}
