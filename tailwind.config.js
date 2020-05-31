module.exports = {
  purge: {
      enabled: false,
  },
  theme: {
    fontFamily: {
      firacode: ["Fira Code"],
      sans: ['Inter var'],
    },
    extend: {
      width: {
        '27': '6.9rem',
        '36': '8.75rem',
        '14': '3.125rem',
        '38': '9.375rem',
      },
      height: {
        '30': '7rem',
        '41': '10.8125rem',
      },
      minHeight: {
        '12': '12rem'
      },
      colors: {
        asphalt: '#23272A',
        midnight: '#2C2F33',
        forest: '#2f3640',
      },
    },
    pagination: theme => ({
      color: theme('colors.purple.600'),
      linkFirst: 'mr-6 border rounded',
      linkSecond: 'rounded-l border-l',
      linkBeforeLast: 'rounded-r border-r',
      linkLast: 'ml-6 border rounded',
    })
  },
  variants: {
    backgroundColor: ['dark', 'dark-hover', 'dark-group-hover', 'responsive', 'hover', 'focus'],
    borderColor: ['dark', 'dark-focus', 'dark-focus-within', 'responsive', 'hover', 'focus'],
    textColor: ['dark', 'dark-hover', 'dark-active', 'responsive', 'hover', 'focus']
  },
  plugins: [
    require('@tailwindcss/ui'),
    require('tailwindcss-dark-mode')(),
  ]
}