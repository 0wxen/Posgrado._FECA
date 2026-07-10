import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

// Frontend puro (SPA). El backend PHP+Postgres vive en ../backend/php,
// servido aparte (ver PosgradoReact/README.md).
export default defineConfig({
  plugins: [react()],
  server: {
    port: 5173,
  },
});
