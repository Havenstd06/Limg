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
        asphalt: '#34495e',
        midnight: '#38546b',
        forest: '#0a3d62',
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