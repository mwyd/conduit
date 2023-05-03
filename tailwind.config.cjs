/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/views/**/*.blade.php",
    "./resources/ts/**/*.{js,jsx,ts,tsx}"
  ],
  darkMode: 'class',
  theme: {
    extend: {
      backgroundColor: {
        "semi-transparent": "rgba(0, 0, 0, 0.4)"
      }
    },
  },
  plugins: [],
}