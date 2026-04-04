export function initBookAnimation() {
    const cards = document.querySelectorAll(".book-card");

    if (!cards.length) return;

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    const card = entry.target;

                    setTimeout(() => {
                        card.style.opacity = "1";
                        card.style.transform = "translateY(0)";
                        card.style.transition =
                            "opacity .6s cubic-bezier(.22,1,.36,1), transform .6s cubic-bezier(.22,1,.36,1)";
                    }, index * 300);

                    observer.unobserve(card);
                }
            });
        },
        {
            threshold: 0.15,
        },
    );

    cards.forEach((card) => {
        card.style.opacity = "0";
        card.style.transform = "translateY(60px)";

        observer.observe(card);
    });
}
