const mix = require("laravel-mix");
require("laravel-mix-merge-manifest");

if (mix.inProduction()) {
    var publicPath = "publishable/assets";
} else {
    var publicPath = "../../../public/themes/pureencapsulations/assets";
}

mix.setPublicPath(publicPath).mergeManifest();
mix.disableNotifications();

mix.js([__dirname + "/src/Resources/assets/js/app.js"], "js/shop.js")
    .copyDirectory(__dirname + "/src/Resources/assets/images", publicPath + "/images")
    .sass(__dirname + "/src/Resources/assets/sass/app.scss", "css/shop.css")
    .sass(__dirname + "/src/Resources/assets/scss/main.scss", "css/main.css")
    .options({
        processCssUrls: false
    });

mix.webpackConfig({
    resolve: {
        alias: {
            'jquery': path.join(__dirname, 'node_modules/jquery/src/jquery')
        }
    }
});

if (mix.inProduction()) {
    mix.version();
}