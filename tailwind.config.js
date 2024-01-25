/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["app/views/**/*.{html,js,php}"],
  theme: {
    container: {
      center: true,
      padding: '1rem',
    },
    screens: {
      lg: { max: "1023px" },
      md: { max: "767px" },
      sm: { max: "639px" },
    },
    extend: {
      colors: {
        gold: {
          1: '#F9F295',
          2: '#E0AA3E',
          3: '#FAF398',
          4: '#B88A44',
        },
      },
    }
  },
  plugins: [require("@tailwindcss/forms")],
};
