export function initRating() {
    const stars = document.querySelectorAll(".star-btn");
    const input = document.getElementById("ratingInput");

    if (!stars.length || !input) return;

    function setRating(value) {
        input.value = value;

        stars.forEach((star, index) => {
            if (index < value) {
                star.classList.add("text-yellow-400");
                star.classList.remove("text-gray-300");
            } else {
                star.classList.remove("text-yellow-400");
                star.classList.add("text-gray-300");
            }
        });
    }

    stars.forEach((star) => {
        star.addEventListener("click", () => {
            setRating(star.dataset.value);
        });
    });

    setRating(input.value);
}
