var elixir = require('laravel-elixir');

elixir.config.assetsPath = 'modules/backend/files/resources/assets';
elixir.config.publicPath = 'assets';
elixir.config.notifications = false;

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

    // Copy Semantic UI Sources
    mix.copy('node_modules/semantic-ui-css/semantic.min.css', 'assets/css/semantic.min.css');
    mix.copy('node_modules/semantic-ui-css/semantic.min.js', 'assets/js/semantic.min.js');

    // Compile our backend's LESS
    mix.less('app.less');
});
