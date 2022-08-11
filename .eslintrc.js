module.exports = {
    env: {
        "browser": true,
        "commonjs": true,
        "es6": true,
    },
    extends: [
        // add more generic rule sets here, such as:
        'eslint:recommended',
        'plugin:vue/recommended',
    ],
    "parserOptions": {
        "sourceType": "module",
        "ecmaVersion": 13,
    },
    rules: {
        // override/add rules settings here, such as:
        'vue/no-v-html': 'off',
        'vue/no-unused-vars': 'error',
        'vue/no-mutating-props': 'off',
        'vue/html-indent': ['error', 4],
        'vue/valid-v-slot': ['error', {allowModifiers: true}]
    }
}
