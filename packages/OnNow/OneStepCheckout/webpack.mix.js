const mix = require("laravel-mix");
require("laravel-mix-merge-manifest");

if (mix.inProduction()) {
    var publicPath = "publishable/assets";
} else {
    var publicPath = "../../../public/themes/osc/assets";
}

mix.setPublicPath(publicPath).mergeManifest();
mix.disableNotifications();

mix.js([__dirname + "/src/Resources/assets/js/app.js"], "js/checkout.js")
    .copyDirectory(__dirname + "/src/Resources/assets/images", publicPath + "/images")
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