export function initCarousel() {
    const books = [
        {
            title: "Sapiens",
            author: "Yuval Noah Harari",
            image: "https://covers.openlibrary.org/b/isbn/9780062316097-L.jpg",
        },
        {
            title: "The Subtle Art of Not Giving a F*ck",
            author: "Mark Manson",
            image: "https://covers.openlibrary.org/b/isbn/9780062457714-L.jpg",
        },
        {
            title: "The Alchemist",
            author: "Paulo Coelho",
            image: "https://covers.openlibrary.org/b/isbn/9780061122415-L.jpg",
        },
        {
            title: "To Kill a Mockingbird",
            author: "Harper Lee",
            image: "https://covers.openlibrary.org/b/isbn/9780060935467-L.jpg",
        },
        {
            title: "1984",
            author: "George Orwell",
            image: "https://covers.openlibrary.org/b/isbn/9780451524935-L.jpg",
        },
        {
            title: "Harry Potter and the Sorcerer's Stone",
            author: "J.K. Rowling",
            image: "https://covers.openlibrary.org/b/isbn/9780590353427-L.jpg",
        },
        {
            title: "The Hobbit",
            author: "J.R.R. Tolkien",
            image: "https://covers.openlibrary.org/b/isbn/9780547928227-L.jpg",
        },
        {
            title: "The Great Gatsby",
            author: "F. Scott Fitzgerald",
            image: "https://covers.openlibrary.org/b/isbn/9780743273565-L.jpg",
        },
        {
            title: "The Catcher in the Rye",
            author: "J.D. Salinger",
            image: "https://covers.openlibrary.org/b/isbn/9780316769488-L.jpg",
        },
        {
            title: "Pride and Prejudice",
            author: "Jane Austen",
            image: "https://covers.openlibrary.org/b/isbn/9780141439518-L.jpg",
        },
    ];

    let current = 0;

    const leftCard = document.getElementById("leftCard");
    const centerCard = document.getElementById("centerCard");
    const rightCard = document.getElementById("rightCard");

    const leftImg = document.getElementById("leftImg");
    const centerImg = document.getElementById("centerImg");
    const rightImg = document.getElementById("rightImg");

    const title = document.getElementById("bookTitle");
    const author = document.getElementById("bookAuthor");

    if (!centerImg) return;

    function updateSlider() {
        const left = (current - 1 + books.length) % books.length;
        const right = (current + 1) % books.length;

        centerImg.src = books[current].image;
        leftImg.src = books[left].image;
        rightImg.src = books[right].image;

        title.innerText = books[current].title;
        author.innerText = books[current].author;

        centerCard.style.transform = "translateX(0) scale(1.15) rotateY(0deg)";

        leftCard.style.transform =
            "translateX(-240px) scale(.85) rotateY(25deg)";

        rightCard.style.transform =
            "translateX(240px) scale(.85) rotateY(-25deg)";
    }

    function nextSlide() {
        centerCard.style.transform =
            "translateX(-240px) scale(.85) rotateY(25deg)";

        rightCard.style.transform = "translateX(0) scale(1.15) rotateY(0deg)";

        leftCard.style.opacity = "0.3";

        setTimeout(() => {
            current = (current + 1) % books.length;
            updateSlider();

            leftCard.style.opacity = "0.6";
        }, 420);
    }

    function prevSlide() {
        centerCard.style.transform =
            "translateX(240px) scale(.85) rotateY(-25deg)";

        leftCard.style.transform = "translateX(0) scale(1.15) rotateY(0deg)";

        rightCard.style.opacity = "0.3";

        setTimeout(() => {
            current = (current - 1 + books.length) % books.length;
            updateSlider();

            rightCard.style.opacity = "0.6";
        }, 420);
    }

    window.nextSlide = nextSlide;
    window.prevSlide = prevSlide;

    setInterval(() => {
        nextSlide();
    }, 3000);

    updateSlider();
}
