import { defineConfig } from "vite";
import { resolve } from "path";

const publicDir = resolve(__dirname, "../../Public/JavaScript");

export default defineConfig({
  build: {
    manifest: false,
    outDir: publicDir,
    emptyOutDir: false,
    rollupOptions: {
      input: {
        lalalytics: "lalalytics.ts",
      },
      output: {
        entryFileNames: "[name].js",
        chunkFileNames: "[name]-[hash].js",
      },
    },
  },
});
