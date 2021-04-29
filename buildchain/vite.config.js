import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default ({ command }) => ({
  base: command === 'serve' ? '' : '/dist/',
  build: {
    manifest: true,
    outDir: 'dist/',
    rollupOptions: {
      input: {
        main: '/src/main.js',
      }
    }
  },
  plugins: [vue()],
});
