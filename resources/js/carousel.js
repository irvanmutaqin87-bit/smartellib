export function initCarousel() {
    const books = window.carouselBooks || [];

    if (!books.length) return;

    let current = 0;
    let autoSlide;

    const leftCard = document.getElementById("leftCard");
    const centerCard = document.getElementById("centerCard");
    const rightCard = document.getElementById("rightCard");

    const leftImg = document.getElementById("leftImg");
    const centerImg = document.getElementById("centerImg");
    const rightImg = document.getElementById("rightImg");

    const leftLink = document.getElementById("leftLink");
    const centerLink = document.getElementById("centerLink");
    const rightLink = document.getElementById("rightLink");

    const title = document.getElementById("bookTitle");
    const author = document.getElementById("bookAuthor");

    if (!centerImg || books.length < 1) return;

    function updateSlider() {
        const left = (current - 1 + books.length) % books.length;
        const right = (current + 1) % books.length;

        centerImg.src = books[current].image;
        leftImg.src = books[left].image;
        rightImg.src = books[right].image;

        centerLink.href = books[current].url;
        leftLink.href = books[left].url;
        rightLink.href = books[right].url;

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

    function startAutoSlide() {
        stopAutoSlide();
        autoSlide = setInterval(() => {
            nextSlide();
        }, 3000);
    }

    function stopAutoSlide() {
        if (autoSlide) clearInterval(autoSlide);
    }

    window.nextSlide = nextSlide;
    window.prevSlide = prevSlide;

    updateSlider();
    startAutoSlide();

    [leftCard, centerCard, rightCard].forEach((card) => {
        card?.addEventListener("mouseenter", stopAutoSlide);
        card?.addEventListener("mouseleave", startAutoSlide);
    });
}
