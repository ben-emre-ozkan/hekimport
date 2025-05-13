import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import colors from 'tailwindcss/colors';
import aspectRatio from '@tailwindcss/aspect-ratio';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/livewire/livewire/src/**/*.blade.php',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                orbitron: ['Orbitron', 'sans-serif'],
                heading: ['Georgia', 'Times New Roman', 'serif'],
                body: ['Verdana', 'Arial', 'sans-serif'],
            },
            colors: {
                danger: colors.rose,
                primary: {
                    '50': '#ecfdf9',
                    '100': '#d0fcf4',
                    '200': '#a7f5e8',
                    '300': '#6febd8',
                    '400': '#38d6c2',
                    '500': '#00c8b3',
                    '600': '#00a192',
                    '700': '#008077',
                    '800': '#00665f',
                    '900': '#00544f',
                    '950': '#00302e',
                },
                secondary: {
                    '50': '#f0f9ff',
                    '100': '#e0f1fe',
                    '200': '#bae4fd',
                    '300': '#7dd1fc',
                    '400': '#38b6f9',
                    '500': '#0e99f0',
                    '600': '#0099e5',
                    '700': '#0169a9',
                    '800': '#075d8a',
                    '900': '#094d72',
                    '950': '#06304b',
                },
            }
        },
    },

    plugins: [forms, aspectRatio],
};
