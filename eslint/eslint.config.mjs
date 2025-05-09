/**
 * ESLint Configuration for Magento Project
 *
 * This configuration extends Magento, jQuery, and reset ESLint rules,
 * while enforcing Magento coding standards using the `magento-coding-standard-eslint-plugin`.
 * It uses FlatCompat to handle multiple config files in a modular way.
 */

import { defineConfig } from "eslint/config";
import magentoCodingStandardEslintPlugin from "magento-coding-standard-eslint-plugin";
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
export default defineConfig([{
    extends: compat.extends(
        "./.eslintrc-reset", // Resets all rules before applying custom ones
        "./.eslintrc-magento", // Magento-specific coding standards
        "./.eslintrc-jquery", // jQuery-related ESLint Rules
        "./.eslintrc-misc", // Miscellaneous Rules
    ),
    plugins: {
        "magento-coding-standard-eslint-plugin": magentoCodingStandardEslintPlugin,  // This is in flat config format (object)
    }
}]);
