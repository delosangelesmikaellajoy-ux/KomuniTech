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
            // ===== Color Palette =====
            colors: {
                // Brand primary colors
                primary: {
                    50: '#f0f7ff',
                    100: '#e0efff',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                    900: '#0c3d66',
                    950: '#051c33',
                },
                // Neutral palette for backgrounds, text, borders
                neutral: {
                    50: '#fafafa',
                    100: '#f5f5f5',
                    200: '#eeeeee',
                    300: '#e0e0e0',
                    400: '#bdbdbd',
                    500: '#9e9e9e',
                    600: '#757575',
                    700: '#616161',
                    800: '#424242',
                    900: '#212121',
                    950: '#0a0a0a',
                },
                // Status colors
                success: {
                    50: '#f0fdf4',
                    100: '#dcfce7',
                    200: '#bbf7d0',
                    400: '#4ade80',
                    500: '#22c55e',
                    600: '#16a34a',
                    700: '#15803d',
                    800: '#166534',
                },
                warning: {
                    50: '#fffbeb',
                    100: '#fef3c7',
                    200: '#fde68a',
                    400: '#facc15',
                    500: '#eab308',
                    600: '#ca8a04',
                    700: '#a16207',
                    800: '#854d0e',
                },
                error: {
                    50: '#fef2f2',
                    100: '#fee2e2',
                    200: '#fecaca',
                    400: '#f87171',
                    500: '#ef4444',
                    600: '#dc2626',
                    700: '#b91c1c',
                    800: '#991b1b',
                },
                info: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                },
            },
            // ===== Typography =====
            fontFamily: {
                sans: ['Quicksand', ...defaultTheme.fontFamily.sans],
                cute: ['Quicksand', 'sans-serif'],
            },
            fontSize: {
                'xs': ['0.75rem', { lineHeight: '1rem' }],          // 12px
                'sm': ['0.875rem', { lineHeight: '1.25rem' }],      // 14px
                'base': ['1rem', { lineHeight: '1.5rem' }],         // 16px
                'lg': ['1.125rem', { lineHeight: '1.75rem' }],      // 18px
                'xl': ['1.25rem', { lineHeight: '1.75rem' }],       // 20px
                '2xl': ['1.5rem', { lineHeight: '2rem' }],          // 24px
                '3xl': ['1.875rem', { lineHeight: '2.25rem' }],     // 30px
                '4xl': ['2.25rem', { lineHeight: '2.5rem' }],       // 36px\n                '5xl': ['3rem', { lineHeight: '1.2' }],             // 48px
            },
            // ===== Spacing =====
            spacing: {
                xs: '0.25rem',    // 4px
                sm: '0.5rem',     // 8px
                md: '1rem',       // 16px
                lg: '1.5rem',     // 24px
                xl: '2rem',       // 32px
                '2xl': '2.5rem',  // 40px
                '3xl': '3rem',    // 48px
                '4xl': '4rem',    // 64px
            },
            // ===== Border Radius =====
            borderRadius: {
                none: '0',
                xs: '0.25rem',    // 4px
                sm: '0.375rem',   // 6px
                md: '0.5rem',     // 8px
                lg: '0.75rem',    // 12px
                xl: '1rem',       // 16px
                '2xl': '1.5rem',  // 24px
                '3xl': '2rem',    // 32px
                full: '9999px',
            },
            // ===== Box Shadows =====
            boxShadow: {
                none: 'none',
                xs: '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
                sm: '0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)',
                base: '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
                md: '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
                lg: '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
                xl: '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
                '2xl': '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
                'inner': 'inset 0 2px 4px 0 rgba(0, 0, 0, 0.05)',
                'dark': '0 10px 40px rgba(0, 0, 0, 0.2)',
            },
            // ===== Transitions =====
            transitionDuration: {
                fast: '150ms',
                base: '200ms',
                slow: '300ms',
            },
        },
    },

    plugins: [forms],
};
