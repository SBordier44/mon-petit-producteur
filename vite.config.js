import {defineConfig} from "vite";
import symfonyPlugin from "vite-plugin-symfony";
import reactPlugin from "@vitejs/plugin-react";
import {resolve} from "path";

export default defineConfig({
    plugins: [
        reactPlugin(),
        symfonyPlugin({
            stimulus: true
        }),
    ],
    build: {
        rollupOptions: {
            input: {
                app: "./assets/app.js"
            },
        }
    },
});
