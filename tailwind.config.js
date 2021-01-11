const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter var", ...defaultTheme.fontFamily.sans],
                body: ['"Helvetica Neue"', ...defaultTheme.fontFamily.sans]
            },
            colors: {
                primary: {
                    lighter: "#007de4",
                    light: "#0067bd",
                    default: "#005296",
                    dark: "#004782",
                    darker: "#003d6f"
                },
            },
        },
    },
    variants: {},
    purge: {
        content: [
            "./app/**/*.php",
            "./resources/**/*.html",
            "./resources/**/*.js",
            "./resources/**/*.jsx",
            "./resources/**/*.ts",
            "./resources/**/*.tsx",
            "./resources/**/*.php",
            "./resources/**/*.vue",
            "./resources/**/*.twig"
        ],
        options: {
            defaultExtractor: content =>
                content.match(/[\w-/.:]+(?<!:)/g) || [],
            whitelistPatterns: [/-active$/, /-enter$/, /-leave-to$/, /show$/]
        }
    },
    plugins: [require("@tailwindcss/ui"), require("@tailwindcss/typography")]
};
