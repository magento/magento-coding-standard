/**
 * ESLint Configuration for Magento Project
 *
 * This configuration extends Magento, jQuery, and reset ESLint rules,
 * while enforcing Magento coding standards using `eslint-plugin-magento`.
 * It uses FlatCompat to handle multiple config files in a modular way.
 */

import { defineConfig } from "eslint/config";
import magentoCodingStandardEslintPlugin from "./index.js";
import path from "node:path";
import { fileURLToPath } from "node:url";
import js from "@eslint/js";
import { FlatCompat } from "@eslint/eslintrc";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const compat = new FlatCompat({
    baseDirectory: __dirname,
    recommendedConfig: js.configs.recommended,
    allConfig: js.configs.all
});
export default defineConfig([
    // ignores-only object = global ignores (do not lint the ESM plugin itself)
    {
        ignores: [
            "**/magento-coding-standard/eslint/**/*.js",
            "**/eslint/rules/**/*.js",
            "**/eslint/index.js"
        ]
    },
    {
        extends: compat.extends(
            "./.eslintrc-reset", // Resets all rules before applying custom ones
            "./.eslintrc-magento", // Magento-specific coding standards
            "./.eslintrc-jquery", // jQuery-related ESLint Rules
            "./.eslintrc-misc", // Miscellaneous Rules
        ),
        plugins: {
            "eslint-plugin-magento": magentoCodingStandardEslintPlugin
        }
    },
    {
        languageOptions: {
            sourceType: "script" // ensures non-module (classic script) parsing
        },
        rules: {
            strict: ["error", "function"] // enforces "use strict" inside functions
        }
    }
]);
