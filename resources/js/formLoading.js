export function initFormLoading() {
    const form = document.querySelector("form");

    if (!form) return;

    const button =
        document.getElementById("loginButton") ||
        document.getElementById("registerButton");

    const text =
        document.getElementById("loginText") ||
        document.getElementById("registerText");

    const spinner =
        document.getElementById("loginSpinner") ||
        document.getElementById("registerSpinner");

    const email = document.getElementById("email");
    const password = document.getElementById("password");

    form.addEventListener("submit", () => {
        if (!email?.value.trim() || !password?.value.trim()) return;

        button.disabled = true;

        button.classList.add("opacity-70", "cursor-not-allowed");

        if (text) text.textContent = "Memproses...";
        if (spinner) spinner.classList.remove("hidden");
    });
}
