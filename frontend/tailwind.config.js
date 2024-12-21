/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'false',
  content: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  theme: {
    extend: {
      spacing: {
        128: '32rem',
      },
    },
  },
  plugins: [],
}
