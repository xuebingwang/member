// http://eslint.org/docs/user-guide/configuring

module.exports = {
    root: true,
    parser: 'babel-eslint',
    parserOptions: {
        sourceType: 'module'
    },
    env: {
        browser: true,
    },
    // https://github.com/feross/standard/blob/master/RULES.md#javascript-standard-style
    extends: 'airbnb-base',
    // required to lint *.vue files
    plugins: [
        'html'
    ],
    // add your custom rules here
    'rules': {
        // don't require .vue extension when importing
        'arrow-parens': [2, "as-needed", {
            "requireForBlockBody": false
        }],
        'indent': ['error', 4, {
            'SwitchCase': 1
        }],
        // don't require .vue extension when importing
        'import/extensions': ['error', 'always', {
            'js': 'never',
            'vue': 'never'
        }],
        // allow optionalDependencies
        'import/no-extraneous-dependencies': ['error', {
            'optionalDependencies': ['test/unit/index.js']
        }],
        // allow console during development
        'no-console': process.env.NODE_ENV === 'production' ? 0 : 0,
        // allow debugger during development
        'no-debugger': process.env.NODE_ENV === 'production' ? 2 : 0,
        'no-param-reassign': ['error', {
            'props': false
        }]
    }
};
