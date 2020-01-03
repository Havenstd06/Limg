module.exports = {
  theme: {
    fontFamily: {
      'firacode': ["Fira Code"],
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
      link: 'bg-forest text-gray-300 px-4 py-2 no-underline',
      linkHover: 'bg-purple-400 border-purple-500 text-gray-800 font-bold',
      linkActive: 'bg-purple-400 border-purple-500 text-gray-800 font-bold',
      linkSecond: 'rounded-l',
      linkBeforeLast: 'rounded-r',
      linkDisabled: 'bg-forest',
      linkFirst: {
        '@apply mr-3 pl-5': {},
        'border-top-left-radius': '999px',
      },
      linkLast: {
        '@apply ml-3 pr-5': {},
        'border-top-right-radius': '999px',
      },
    }),
  },
  variants: {
    backgroundColor: ['dark', 'dark-hover', 'dark-group-hover'],
    borderColor: ['dark', 'dark-focus', 'dark-focus-within'],
    textColor: ['dark', 'dark-hover', 'dark-active']
  },
  plugins: [
    require('tailwindcss-dark-mode')(),
    require('tailwindcss-plugins/pagination'),
  ]
}