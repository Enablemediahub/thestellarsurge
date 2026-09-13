/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.css',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                plum: '#32152F',
                gold: '#C8A46A',
                ivory: '#F7F2E9',
                taupe: '#D8CEC2',
                charcoal: '#242124',
            },
            fontFamily: {
                display: ['"Playfair Display"', 'serif'],
                sans: ['Inter', 'sans-serif'],
                subheading: ['Montserrat', 'sans-serif'],
            },
            boxShadow: {
                'brand': '0 18px 40px rgba(50, 21, 47, 0.12)',
            },
        },
    },
    plugins: [],
};
