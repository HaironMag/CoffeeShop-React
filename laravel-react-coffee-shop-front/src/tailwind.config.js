/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        'coffee-dark': '#2D1B0C',
        'coffee-medium': '#8B5A2B',
        'coffee-light': '#D4A76A',
        'cream-dark': '#7D6E5E',
        'cream-medium': '#F5E8D0',
        'cream-light': '#FFFCF5',
      },
      fontFamily: {
        'outfit': ['Outfit', 'sans-serif'],
        'playfair': ['Playfair Display', 'serif'],
      },
    },
  },
  plugins: [],
}
}