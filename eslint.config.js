import js from '@eslint/js';
import prettier from 'eslint-config-prettier/flat';
import globals from 'globals';

/** @type {import('eslint').Linter.Config[]} */
export default [
    js.configs.recommended,
    {
        languageOptions: {
            globals: {
                ...globals.browser,
            },
        },
    },
    {
        ignores: ['vendor', 'node_modules', 'public', 'tailwind.config.js'],
    },
    prettier, // Turn off all rules that might conflict with Prettier
];