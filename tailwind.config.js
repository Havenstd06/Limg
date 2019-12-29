module.exports = {
  theme: {
    fontFamily: {
      'firacode': ["Fira Code"],
    },
    extend: {
      width: {
        '36': '8.75rem',
        '14': '3.125rem',
        '38': '9.375rem',
      },
      height: {
        '30': '7rem',
      },
      minHeight: {
        '12': '12rem'
      },
      colors: {
        asphalt: '#23272A',
        midnight: '#2C2F33',
        forest: '#99AAB5',
      },
    },
  },
  variants: {
    backgroundColor: ['dark', 'dark-hover', 'dark-group-hover'],
    borderColor: ['dark', 'dark-focus', 'dark-focus-within'],
    textColor: ['dark', 'dark-hover', 'dark-active']
  },
  plugins: [
    require('tailwindcss-dark-mode')()
  ]
}