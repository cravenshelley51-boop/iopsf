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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'gold-premium': {
                    50: '#fffcf0',
                    100: '#fef7cf',
                    200: '#fded9f',
                    300: '#fcdf6f',
                    400: '#fbc92f',
                    500: '#f5b00b',
                    600: '#d98b06',
                    700: '#b46809',
                    800: '#924d0e',
                    900: '#783e0f',
                    950: '#451e03',
                },
                'vault-dark': {
                    50: '#f4f4f5',
                    100: '#e4e4e7',
                    200: '#d4d4d8',
                    300: '#a1a1aa',
                    400: '#71717a',
                    500: '#52525b',
                    600: '#3f3f46',
                    700: '#27272a',
                    800: '#18181b',
                    900: '#09090b',
                    950: '#030303',
                },
            },
            borderRadius: {
                'xl': '1rem',
                '2xl': '1.5rem',
                '3xl': '2rem',
            },
            boxShadow: {
                'premium': '0 10px 30px -5px rgba(212, 175, 55, 0.1), 0 8px 10px -6px rgba(212, 175, 55, 0.1)',
                'premium-hover': '0 20px 40px -5px rgba(212, 175, 55, 0.2), 0 12px 16px -6px rgba(212, 175, 55, 0.2)',
            },
        },
    },

    plugins: [forms],
};
