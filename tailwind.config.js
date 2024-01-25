/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["app/views/**/*.{html,js,php}"],
  theme: {
    container: {
      center: true,
    },
    screens: {
      "2xl": { max: "1535px" },
      xl: { max: "1279px" },
      lg: { max: "1023px" },
      md: { max: "767px" },
      sm: { max: "639px" },
    },
    extend: {
      colors: {
        gold: {
          50: '#fef5e4',
          100: '#fde7bc',
          200: '#fcd98d',
          300: '#fcc55e',
          400: '#fbb72c',
          500: '#faa520',
          600: '#f9900f',
          700: '#f87c00',
          800: '#f76800',
          900: '#f65100',
        },
      },
    }
  },
  plugins: [require("@tailwindcss/forms")],
};
