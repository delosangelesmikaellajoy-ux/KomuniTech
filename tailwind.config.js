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
                // Replace Figtree with Quicksand for a friendly, cute vibe
                sans: ['Quicksand', ...defaultTheme.fontFamily.sans],
                cute: ['Quicksand', 'sans-serif'], // optional custom alias
            },
        },
    },

    plugins: [forms],
};
