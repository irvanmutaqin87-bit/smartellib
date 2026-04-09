export function initSearchNavbar() {
    console.log("Search Navbar JS aktif");

    const input = document.getElementById("searchInputNavbar");
    const button = document.getElementById("searchBtnNavbar");
    const container = document.getElementById("resultContainer");
    const emptyText = document.getElementById("emptyText");
    const spinner = document.getElementById("loadingSpinner");
    const defaultText = document.getElementById("defaultText");

    if (!input) return;

    let debounceTimer = null;
    let controller = null;

    // =========================
    // JIKA BUKAN HALAMAN SEARCH
    // =========================
    if (!window.isSearchPage) {
        input.addEventListener("click", function () {
            window.location.href = window.searchPageUrl;
        });

        button?.addEventListener("click", function () {
            window.location.href = window.searchPageUrl;
        });

        return;
    }

    // =========================
    // JIKA HALAMAN SEARCH
    // =========================
    if (!container) return;

    // Auto focus saat masuk halaman search
    setTimeout(() => {
        input.focus();
        input.setSelectionRange(input.value.length, input.value.length);
    }, 200);

    function showLoading() {
        if (!spinner) return;
        spinner.classList.remove("hidden");
        spinner.classList.add("flex");
    }

    function hideLoading() {
        if (!spinner) return;
        spinner.classList.add("hidden");
        spinner.classList.remove("flex");
    }

    function clearResults() {
        container.innerHTML = "";
        emptyText?.classList.add("hidden");
    }

    function showDefaultText(show = true) {
        if (!defaultText) return;
        defaultText.classList.toggle("hidden", !show);
    }

    function escapeHtml(text) {
        if (!text) return "";
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function getSafeCover(cover) {
        if (!cover) return "/images/default-book.png";

        // Kalau sudah absolute URL / root path
        if (
            cover.startsWith("http://") ||
            cover.startsWith("https://") ||
            cover.startsWith("/")
        ) {
            return cover;
        }

        // fallback kalau backend ngirim path mentah
        return `/storage/${cover.replace(/^storage\//, "")}`;
    }

    function renderBooks(data) {
        console.log("Data hasil search:", data);

        container.innerHTML = "";

        if (!data || data.length === 0) {
            emptyText?.classList.remove("hidden");
            return;
        }

        data.forEach((book) => {
            const cover = getSafeCover(book.cover);

            container.innerHTML += `
                <a href="/anggota/buku/${book.id}"
                   class="book-card group block cursor-pointer">

                    <div class="
                        relative overflow-hidden rounded-xl
                        shadow-[0_6px_18px_rgba(0,0,0,0.08)]
                        transition-all duration-500
                        group-hover:-translate-y-3
                        group-hover:shadow-[0_20px_45px_rgba(0,0,0,0.20)]
                    ">

                        <div class="
                            absolute inset-0
                            bg-gradient-to-t
                            from-black/10 via-transparent to-transparent
                            opacity-0 group-hover:opacity-100 transition
                        "></div>

                        <img src="${cover}"
                             alt="${escapeHtml(book.judul)}"
                             class="
                                w-full aspect-[2/3] object-cover
                                brightness-110 contrast-110
                                transition duration-500
                                group-hover:scale-105
                             "
                             onerror="this.onerror=null;this.src='/images/default-book.png';"
                        />
                    </div>

                    <h3 class="mt-3 text-sm font-semibold text-gray-800 line-clamp-2">
                        ${escapeHtml(book.judul)}
                    </h3>

                    <p class="text-xs text-gray-500">
                        ${escapeHtml(book.penulis ?? "-")}
                    </p>
                </a>
            `;
        });
    }

    async function doSearch(query) {
        console.log("Mencari:", query);

        if (!query || query.length < 1) {
            clearResults();
            hideLoading();
            showDefaultText(true);
            return;
        }

        showDefaultText(false);

        if (controller) {
            controller.abort();
        }

        controller = new AbortController();

        showLoading();
        emptyText?.classList.add("hidden");

        try {
            const response = await fetch(
                `${window.searchAjaxUrl}?q=${encodeURIComponent(query)}`,
                {
                    signal: controller.signal,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        Accept: "application/json",
                    },
                },
            );

            if (!response.ok) {
                throw new Error("Gagal mengambil data");
            }

            const data = await response.json();
            renderBooks(data);
        } catch (error) {
            if (error.name !== "AbortError") {
                console.error("Search error:", error);
                clearResults();
                emptyText?.classList.remove("hidden");
            }
        } finally {
            hideLoading();
        }
    }

    // =========================
    // EVENT SEARCH REALTIME
    // =========================
    input.addEventListener("input", function () {
        const query = input.value.trim();

        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            doSearch(query);
        }, 250);
    });

    input.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            clearTimeout(debounceTimer);
            doSearch(input.value.trim());
        }
    });

    button?.addEventListener("click", function () {
        clearTimeout(debounceTimer);
        doSearch(input.value.trim());
    });

    // Kalau ada value awal, langsung search
    if (input.value.trim().length > 0) {
        doSearch(input.value.trim());
    }
}
