import { defineConfig } from "vite";
import * as path from "path";

export default defineConfig({
  root: path.resolve(__dirname, 'src'),
  publicDir: path.resolve(__dirname, 'public'),
  plugins: [],
  build: {
    outDir: path.resolve(__dirname, 'dist'),
    minify: true,
    emptyOutDir: true,
    manifest: true,
    watch: {
      include: [
        './classes/**/*.php',
        './html/**/*.{html,php}',
        './src/**/*.{css,js,ts}'
      ],
      exclude: [
        'node_modules/**/*',
        'vendor/**/*'
      ]
    },
    rollupOptions: {
      input: {
        index: path.resolve(__dirname, 'src/index.js'),
      },
      output: {
        entryFileNames: `assets/[name].js`,
        chunkFileNames: `assets/[name].js`,
        assetFileNames: `assets/[name].[ext]`,
      },
    }
  },

})
