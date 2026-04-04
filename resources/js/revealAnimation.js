export function initRevealAnimation() {
    const animationMap = {
        "reveal-left": "animate-slideLeft",
        "reveal-right": "animate-slideRight",
        "reveal-up": "animate-slideUp",
        "reveal-scale": "animate-scaleIn",
    };

    const observer = new IntersectionObserver(
        (entries, observer) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;

                for (let key in animationMap) {
                    if (entry.target.classList.contains(key)) {
                        entry.target.classList.add(animationMap[key]);
                        break;
                    }
                }

                observer.unobserve(entry.target);
            });
        },
        { threshold: 0.2 },
    );

    document.querySelectorAll(".reveal").forEach((el) => observer.observe(el));
}
