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
                primary: {
                    50: '#ECFDF5',
                    100: '#D1FAE5',
                    200: '#A7F3D0',
                    300: '#6EE7B7',
                    400: '#34D399',
                    500: '#10B981',
                    600: '#059669',
                    700: '#047857',
                    800: '#065F46',
                    900: '#064E3B',
                    950: '#022C22',
                },
                accent: {
                    50: '#FEF2F2',
                    500: '#EF4444',
                    600: '#DC2626',
                },
                gold: {
                    400: '#FBBF24',
                    500: '#F59E0B',
                    600: '#D97706',
                    700: '#B45309',
                },
                dark: {
                    DEFAULT: '#0F172A',
                    light: '#1E293B',
                },
            },
            boxShadow: {
                'card': '0 2px 15px rgba(16, 185, 129, 0.08)',
                'card-lg': '0 8px 30px rgba(16, 185, 129, 0.15)',
                'card-hover': '0 12px 35px rgba(16, 185, 129, 0.18)',
                'glow': '0 0 20px rgba(16, 185, 129, 0.2)',
                'gold': '0 2px 10px rgba(245, 158, 11, 0.3)',
                'gold-lg': '0 4px 20px rgba(245, 158, 11, 0.4)',
                'btn': '0 4px 20px rgba(16, 185, 129, 0.35)',
            },
            borderRadius: {
                'card': '14px',
            },
            animation: {
                'shimmer': 'shimmer 3s linear infinite',
                'float': 'float 3s ease-in-out infinite',
                'slide-down': 'slideDown 0.3s ease',
                'fade-in': 'fadeIn 0.2s ease-out',
                'card-up': 'cardSlideUp 0.4s ease-out',
            },
            keyframes: {
                shimmer: {
                    '0%': { backgroundPosition: '0% center' },
                    '100%': { backgroundPosition: '200% center' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-20px)' },
                },
                slideDown: {
                    from: { transform: 'translateY(-10px)', opacity: '0' },
                    to: { transform: 'translateY(0)', opacity: '1' },
                },
                fadeIn: {
                    from: { opacity: '0', transform: 'translateY(10px)' },
                    to: { opacity: '1', transform: 'translateY(0)' },
                },
                cardSlideUp: {
                    from: { opacity: '0', transform: 'translateY(20px)' },
                    to: { opacity: '1', transform: 'translateY(0)' },
                },
            },
        },
    },

    plugins: [forms],
};
