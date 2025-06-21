import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms'

/** @type {import('tailwindcss').Config} */
export default {
    content: [
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		'./storage/framework/views/*.php',
		'./resources/**/*.blade.php',
		'./resources/**/*.js',
		'./resources/**/*.vue',
		"./vendor/developermithu/tallcraftui/src/**/*.php",
	],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
             colors: {
                primary: "#6d28d9",
                secondary: "#a21caf",
            },
        },
    },
    plugins: [
         forms,

    ],
};
