/** @type {import('tailwindcss').Config} */
import plugin from "tailwindcss/plugin";

export default {
    content: [
        "./assets/**/*.js",
        "./templates/**/*.html.twig",
        "./node_modules/flowbite/**/*.js",
    ],
    theme: {
        extend: {
            transitionProperty: {
                'height': 'height',
            }
        },
        screens: {
            'xxs': '280px',
            'xs': '320px',
            'sm': '640px',
            'md': '768px',
            'lg': '1024px',
            'xl': '1280px',
            '2xl': '1536px',
        },
        textShadow: {
            sm: '1px 1px 2px var(--tw-shadow-color)',
            DEFAULT: '2px 2px 4px var(--tw-shadow-color)',
            lg: '4px 4px 8px var(--tw-shadow-color)',
            xl: '4px 4px 16px var(--tw-shadow-color)',
        }
    },
    plugins: [
        require('@tailwindcss/typography'),
        require('flowbite/plugin')({
            charts: true,
            forms: true,
            tooltips: true
        }),
        plugin(function ({matchUtilities, theme}) {
            matchUtilities({
                    'text-shadow': (value) => ({
                        textShadow: value,
                    })
                },
                {
                    values: theme('textShadow'),
                })
        }),
    ],
}
