const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/js").postCss(
    "resources/css/app.css",
    "public/css",
    [
        require("postcss-import"),
        require("tailwindcss"),
        require("postcss-nested"),
        require("autoprefixer"),
    ]
);

if (mix.inProduction()) {
    mix.version();
}
mix.sass("resources/css/style-app-user.scss", "css/style-app-user.css");
mix.postCss(
    "resources/css/style-responsive.css",
    "css/style-responsive.css"
).options({
    processCssUrls: false,
});
mix.postCss("resources/css/style.css", "css/style.css").options({
    processCssUrls: false,
});
mix.postCss(
    "resources/css/style-tailwind.css",
    "css/style-tailwind.css"
).options({
    processCssUrls: false,
});
mix.postCss("resources/css/style-custom.css", "css/style-custom.css").options({
    processCssUrls: false,
});

mix.js("resources/js/jquery.dcjqaccordion.2.7.js", "public/js")
    .js("resources/js/jquery.nicescroll.js", "public/js")
    .js("resources/js/scripts.js", "public/js")
    .copy("resources/js/cart_update.js", "public/js/cart_update.js")
    .copy("resources/js/voucher.js", "public/js/voucher.js")
    .copy("resources/js/style.js", "public/js/style.js")
    .copy("resources/js/style_ajax.js", "public/js/style_ajax.js")
    .copy("resources/js/customer_voucher.js", "public/js/customer_voucher.js")
    .copy("resources/js/search.js", "public/js/search.js");

mix.copy("resources/i18n/en.json", "public/i18n/en.json")
    .copy("resources/i18n/vi.json", "public/i18n/vi.json");

mix.copy("resources/js/statistic_order.js", "public/js")
    .copy("resources/js/statistic_revenue.js", "public/js");

mix.js("resources/js/notification_order_status.js", "public/js");
