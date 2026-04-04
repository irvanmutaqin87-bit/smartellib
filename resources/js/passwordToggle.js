export function initPasswordToggle() {
    function setupPasswordToggle(toggleId, inputId) {
        const toggle = document.getElementById(toggleId);
        const input = document.getElementById(inputId);

        if (!toggle || !input) return;

        const eyeOpen = `
        <svg xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor"
            class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
            d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12
            18 19.5 12 19.5 2.25 12 2.25 12z" />
            <path stroke-linecap="round" stroke-linejoin="round"
            d="M12 15.75A3.75 3.75 0 1 0 12 8.25
            a3.75 3.75 0 0 0 0 7.5z" />
        </svg>`;

        const eyeSlash = `
        <svg xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor"
            class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
            d="M3 3l18 18" />
            <path stroke-linecap="round" stroke-linejoin="round"
            d="M10.584 10.587A3.75 3.75 0 0012 15.75
            a3.75 3.75 0 003.163-1.737M9.88 4.243
            A10.45 10.45 0 0112 4.5
            c5.25 0 8.25 4.5 9.75 7.5
            a10.47 10.47 0 01-4.293 5.774M6.228 6.228
            A10.45 10.45 0 002.25 12
            c1.5 3 4.5 7.5 9.75 7.5
            1.104 0 2.136-.157 3.08-.445" />
        </svg>`;

        toggle.innerHTML = eyeOpen;

        toggle.addEventListener("click", () => {
            const isPassword = input.type === "password";

            input.type = isPassword ? "text" : "password";
            toggle.innerHTML = isPassword ? eyeSlash : eyeOpen;
        });
    }

    setupPasswordToggle("toggleOldPassword", "old_password");
    setupPasswordToggle("togglePassword", "password");
    setupPasswordToggle("togglePasswordConfirm", "password_confirmation");
}
