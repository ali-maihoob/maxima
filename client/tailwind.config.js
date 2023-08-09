const colors = require("tailwindcss/colors");

module.exports = {
  content: [
      "./public/**/*.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
    "./node_modules/flowbite/**/*.js"
  ],
  darkMode: "class",
  theme: {
    groupLevel: 10,
    groupScope: "scope",
    groupVariants: ["hover", "focus"],
    extend: {},
    container: {
      center: true,
    },
    colors: {
      yellow: colors.amber,
      purple: colors.violet,
      transparent: "transparent",
      current: "currentColor",
      black: colors.black,
      white: colors.white,
      sky: colors.sky,
      violet: colors.violet,
      zinc: colors.zinc,
      fuchsia: colors.fuchsia,
      indigo: colors.amber,
      dark: colors.neutral,
      gray: colors.gray,
      red: colors.rose,
      green: colors.green,
      lime: colors.lime,
      orange: colors.orange,
    },
  },
  plugins: [
    require('@tailwindcss/line-clamp'),
    require('flowbite/plugin')
  ],
};