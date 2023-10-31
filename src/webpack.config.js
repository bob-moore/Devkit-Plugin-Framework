const path = require('path');
const wpScriptsConfig = require( '@wordpress/scripts/config/webpack.config' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const plugins = wpScriptsConfig.plugins.filter( ( item ) => {
    return ! [ 'CopyPlugin', 'MiniCssExtractPlugin', 'CleanWebpackPlugin' ].includes( item.constructor.name );
} );

module.exports = () =>
{
    const blocks = {
        ...wpScriptsConfig,
        output: {
            path: path.resolve( __dirname, '../blocks' ),
        }
    };
    const global = {
        ...wpScriptsConfig,
        entry : {
            frontend : [ 
                path.resolve( __dirname, 'frontend', 'index.tsx' ),
                path.resolve( __dirname, 'frontend', 'index.scss' )
            ],
            admin : [ 
                path.resolve( __dirname, 'admin', 'index.tsx' ),
                path.resolve( __dirname, 'admin', 'index.scss' )
            ]
        },
        output: {
            path: path.resolve( __dirname, '../dist' ),
            filename : '[name]/bundle.js'
        },
        devServer : {
            devMiddleware: {
                writeToDisk: true,
            },
            allowedHosts: 'auto',
            host: 'localhost',
            port: 'auto',
            proxy: {
                '/dist': {
                    pathRewrite: {
                        '^/dist': '',
                    },
                },
            },
        },
        plugins: [
            ...plugins,
            new CleanWebpackPlugin({
                cleanOnceBeforeBuildPatterns: [ 
                    '*.hot-update.*',
                    '**/*.hot-update.*',
                    '!images/**',
                    '!fonts/**',
                    '!acf/**'
                ],
                dry: false
            }),
            new MiniCssExtractPlugin( { filename : '[name]/bundle.css' } )
        ],
    };
    return [ global, blocks ];
}