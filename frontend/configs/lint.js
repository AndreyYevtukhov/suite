const path = require('path');
const appSettings = require('../settings');
const StyleLintPlugin = require('stylelint-webpack-plugin');

module.exports = {
    mode: 'development',

    entry: './frontend/emptyEntry.js',

    plugins: [
        new StyleLintPlugin({
            context: appSettings.paths.core.modules
        })
    ]
};