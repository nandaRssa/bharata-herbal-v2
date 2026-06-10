import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                emerald: {
                    50: '#f4f8f5',
                    100: '#e5f0e9',
                    200: '#cce1d4',
                    300: '#a3cbbb',
                    400: '#73ae96',
                    500: '#4d9275',
                    600: '#1C4526',
                    700: '#173920',
                    800: '#122c19',
                    900: '#0c1e11',
                    950: '#061009',
                }
            }
        },
    },

    plugins: [forms],
};
