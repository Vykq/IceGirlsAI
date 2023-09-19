const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
var path = require('path');

// change these variables to fit your project
const jsPath= './js';
const cssPath = './css';
const outputPath = 'assets';
const entryPoints = {
    'app': jsPath + '/app.js',
    'style': cssPath + '/style.scss',
};

module.exports = {
    entry: entryPoints,
    output: {
        path: path.resolve(__dirname, outputPath),
        filename: '[name].js',
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: '[name].css',
        }),
    ],

    module: {
        rules: [
            {
                test: /\.s?[c]ss$/i,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'sass-loader'
                ]
            },
            {
                test: /\.sass$/i,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    {
                        loader: 'sass-loader',
                        options: {
                            sassOptions: { indentedSyntax: true }
                        }
                    }
                ]
            },
            {
                test: /\.(jpg|jpeg|png|gif|eot|ttf|svg)$/i,
                use: 'url-loader?limit=1024'
            },
            {
                test: /\.(woff|woff2)$/i,
                type: 'asset/resource',
                dependency: { not: ['url'] },
            }

        ]
    },

};