var elixir = require('laravel-elixir');

elixir.config.assetsPath = 'modules/backend/files/resources/assets';
elixir.config.publicPath = 'assets';
elixir.config.notifications = false;

var sassOptions = {
    includePaths: [
        'node_modules'
    ]
};

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    // Compile our backend's SASS
    mix.sass('app.scss', null, sassOptions);

    // Compile our backend's JS
    mix.browserify('app.js');
});
