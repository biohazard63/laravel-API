import { fileURLToPath, URL } from 'node:url'
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueJsx from '@vitejs/plugin-vue-jsx'
import VueDevTools from 'vite-plugin-vue-devtools'
import WindiCSS from 'vite-plugin-windicss' // Import WindiCSS

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    vueJsx(),
    VueDevTools(),
    WindiCSS(), // Use WindiCSS
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  }
})