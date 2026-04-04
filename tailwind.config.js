/** @type {import('tailwindcss').Config} */

export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    theme: {
        screens: {
            sm: "640px", //hp
            md: "768px", //tablet
            lg: "1024px", //laptop
            xl: "1280px", // dekstop
        },

        extend: {
            fontFamily: {
                sans: ["Poppins", "sans-serif"],
            },

            keyframes: {
                slideLeft: {
                    "0%": { opacity: "0", transform: "translateX(-60px)" },
                    "100%": { opacity: "1", transform: "translateX(0)" },
                },
                slideRight: {
                    "0%": { opacity: "0", transform: "translateX(60px)" },
                    "100%": { opacity: "1", transform: "translateX(0)" },
                },
                slideUp: {
                    "0%": { opacity: "0", transform: "translateY(60px)" },
                    "100%": { opacity: "1", transform: "translateY(0)" },
                },
                scaleIn: {
                    "0%": { opacity: "0", transform: "scale(0.8)" },
                    "100%": { opacity: "1", transform: "scale(1)" },
                },
            },

            animation: {
                slideLeft: "slideLeft 0.8s ease-out forwards",
                slideRight: "slideRight 0.8s ease-out forwards",
                slideUp: "slideUp 0.8s ease-out forwards",
                scaleIn: "scaleIn 0.6s ease-out forwards",
            },
        },
    },

    plugins: [require("@tailwindcss/line-clamp")],
};
