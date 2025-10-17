
module.exports = {
  theme: {
    extend: {
      keyframes: {
        zoomIn: {
          '0%': { transform: 'scale(0.5)', opacity: '0' },
          '100%': { transform: 'scale(1)', opacity: '1' },
        },
      },
      animation: {
        zoomIn: 'zoomIn 0.6s ease-out forwards',
      },
    },
  },
  plugins: [],
}
