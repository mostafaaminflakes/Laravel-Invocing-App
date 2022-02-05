const mix = require("laravel-mix");
const postcssCustomProperties = require("postcss-custom-properties");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js("resources/js/app.js", "public/js")
//     .sass("resources/sass/app.scss", "public/css")
//     .sourceMaps();

// mix.webpackConfig({
//     stats: {
//         children: true,
//     },
// });

// postcss([
//     postcssCustomProperties({
//         preserve: false,
//     }),
// ]).process(YOUR_CSS /*, processOptions */);
// module.exports = {
//     module: {
//         rules: [
//             {
//                 test: /\.css$/,
//                 use: ["style-loader", "postcss-loader"],
//             },
//         ],
//     },
// };
// mix.js("resources/js/app.js", "public/js").postCss(
//     "resources/sass/app.scss",
//     "public/css"
// );

mix.js("resources/js/app.js", "public/js")
    .sass("resources/sass/app.scss", "public/css")
    .options({
        postCss: [
            require("postcss-custom-properties")({
                preserve: false,
            }),
        ],
    })
    .sourceMaps();

// mix.js("resources/js/app.js", "public/js").postCss(
//     "resources/sass/app.scss",
//     "public/css",
//     [
//         postcssCustomProperties({
//             preserve: false,
//         }),
//     ]
// );

// mix.js("resources/js/app.js", "public/js").postCss(
//     "resources/css/app.css",
//     "public/css",
//     [
//         require("bootstrap"),
//         postcssCustomProperties({
//             preserve: false,
//             importFrom: "public/css/app.css",
//         }),
//     ]
// );
