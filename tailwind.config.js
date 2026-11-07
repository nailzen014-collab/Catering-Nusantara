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
            colors: {
                cream: '#F5ECD9',
                paper: '#FFFAF0',
                ink: '#12271B',
                clay: '#A6432D',
                'clay-dark': '#7E301F',
                turmeric: '#C9A35B',
                'turmeric-light': '#E7D2A8',
                leaf: '#4B6043',
                line: '#DFD2B9',
                muted: '#788273',
            },
            fontFamily: {
                display: ['Fraunces', 'Georgia', 'serif'],
                body: ['Karla', ...defaultTheme.fontFamily.sans],
            },
            maxWidth: {
                shell: '1240px',
                prose: '34rem',
            },
        },
    },

    plugins: [forms],
};
