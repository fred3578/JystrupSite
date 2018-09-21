var path = require('path');
var webpack = require('webpack');
var helper=require('path');
module.exports = {
    entry: {
        rolerestriction: './js_screens/main/App.tsx'
    },
    output: {
        filename: './Bundle/[name]_bundle.js'
    },
    resolve: {
        modules: [
            'C:\\wamp\\www\\node_modules'
        ],
        extensions: ['.ts', '.js','.tsx']
    },
    devtool: 'source-map',
    module: {
        rules: [
            { test: /\.(png|woff|woff2|eot|ttf|svg)$/,
                loader: 'url-loader?limit=100000'
            },
            {
                test: /\.css$/,
                use: ["style-loader","css-loader"],
                enforce: "pre"
            },
            {
                test: /\.js$/,
                use: ["source-map-loader"],
                enforce: "pre",
                exclude:helper.resolve(__dirname,'node_modules/@types/es6-promise')
            },
            {
                test: /\.jsx$/,
                use: ["source-map-loader"],
                enforce: "pre",
                exclude:helper.resolve(__dirname,'node_modules/@types/es6-promise')
            },
            {
                test: /\.ts$/,
                use: ["ts-loader"]
            },
            {
                test: /\.tsx$/,
                use: ["ts-loader"]
            }
        ]
    }, externals: {
        "jquery":"jQuery",
        "jQuery":"jQuery"
    },
    plugins:[
        new webpack.optimize.UglifyJsPlugin({
            compress: {
                warnings: false
            }
        }),
        new webpack.ProvidePlugin({
            Promise: 'es6-promise'
        })
    ]
};