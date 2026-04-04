export function initLoadMore(containerId = "bookContainer", step = 20) {
    const scope = document.getElementById(containerId);
    if (!scope) return;

    const books = scope.querySelectorAll(".book-card");
    const button = document.getElementById("loadMoreBtn");

    if (!books.length) return;

    let visible = step;

    function showBooks() {
        books.forEach((book, index) => {
            if (index < visible) {
                book.style.display = "block";
                setTimeout(() => {
                    book.style.opacity = "1";
                    book.style.transform = "translateY(0)";
                }, index * 50);
            } else {
                book.style.display = "none";
            }
        });

        if (button) {
            button.style.display = visible >= books.length ? "none" : "flex";
        }
    }

    window.loadMoreBooks = function () {
        const start = visible;
        visible += step;

        if (visible > books.length) visible = books.length;

        for (let i = start; i < visible; i++) {
            setTimeout(
                () => {
                    books[i].style.display = "block";
                    books[i].style.opacity = "0";
                    books[i].style.transform = "translateY(40px)";

                    requestAnimationFrame(() => {
                        books[i].style.transition = "all .6s ease";
                        books[i].style.opacity = "1";
                        books[i].style.transform = "translateY(0)";
                    });
                },
                (i - start) * 120,
            );
        }

        if (button && visible >= books.length) {
            button.style.display = "none";
        }
    };

    showBooks();
}
