export function initSearch() {
    const input = document.getElementById("searchInput");
    const button = document.getElementById("searchBtn");
    const container = document.getElementById("resultContainer");
    const emptyText = document.getElementById("emptyText");
    const spinner = document.getElementById("loadingSpinner");

    if (!input || !container) return;

    let isLoading = false;

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

    function doSearch() {
        const query = input.value.trim();

        if (query.length < 2) {
            container.innerHTML = "";
            emptyText?.classList.add("hidden");
            hideLoading();
            return;
        }

        // ❗ biar ga spam request
        if (isLoading) return;
        isLoading = true;

        // 🔥 SHOW LOADING
        showLoading();
        container.innerHTML = "";
        emptyText?.classList.add("hidden");

        fetch(`${window.searchUrl}?q=${query}`)
            .then((res) => res.json())
            .then((data) => {
                container.innerHTML = "";

                if (data.length === 0) {
                    emptyText?.classList.remove("hidden");
                    return;
                }

                data.forEach((book) => {
                    container.innerHTML += `
                        <a href="/anggota/detail_buku"
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

                                <img src="${book.cover ?? "https://via.placeholder.com/150"}"
                                    class="
                                        w-full aspect-[2/3] object-cover
                                        brightness-110 contrast-110
                                        transition duration-500
                                        group-hover:scale-105
                                    " />
                            </div>

                            <h3 class="mt-3 text-sm font-semibold text-gray-800">
                                ${book.judul}
                            </h3>

                            <p class="text-xs text-gray-500">
                                ${book.penulis}
                            </p>

                        </a>
                    `;
                });
            })
            .catch(() => {
                emptyText?.classList.remove("hidden");
            })
            .finally(() => {
                // 🔥 HIDE LOADING
                hideLoading();
                isLoading = false;
            });
    }

    // ENTER
    input.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            doSearch();
        }
    });

    // CLICK ICON
    button?.addEventListener("click", doSearch);
}
