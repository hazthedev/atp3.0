import flowbitePlugin from 'flowbite/plugin';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './node_modules/flowbite/**/*.js',
    ],
    theme: {
        extend: {},
    },
    plugins: [flowbitePlugin],
};
