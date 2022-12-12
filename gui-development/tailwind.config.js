/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./public/index.html",
    "./src/hooks/**/.js",
    "./src/components/**/*.jsx",
    "./src/pages/**/*.jsx"
  ],
  theme: {
    extend: {
      fontFamily: {
        'lato': ['Lato', 'sans-serif']
      },
      backgroundImage: {
        'img-close-white': "url('" + __dirname + "/src/img/close/white.png')",
        'img-close-red': "url('" + __dirname + "/src/img/close/red.png')",
      },
    },
  },
  plugins: [],
}
