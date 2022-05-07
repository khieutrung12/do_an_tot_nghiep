module.exports = {
    purge: ["./resources/views/**/*.blade.php", "./resources/css/**/*.css"],
    theme: {
        extend: {},
    },
    variants: {
        extend: {
            visibility: ["group-hover"],
            display: ["group-hover"],
        },
    },
    plugins: [
        require("@tailwindcss/ui"),
        require("tailwindcss-plugins/pagination"),
    ],
};
