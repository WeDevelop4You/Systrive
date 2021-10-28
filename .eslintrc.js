module.exports = {
    env: {
        "browser": true,
        "commonjs": true,
        "es6": true
    },
    extends: [
        // add more generic rule sets here, such as:
        'eslint:recommended',
        'plugin:vue/recommended',
        // 'prettier',
    ],
    "parserOptions": {
        "sourceType": "module"
    },
    rules: {
        // override/add rules settings here, such as:
        'vue/no-unused-vars': 'error',
        'vue/html-indent': ['error', 4],
    }
}
