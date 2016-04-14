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
    mix.copy('node_modules/semantic-ui-css/semantic.min.css', 'assets/css');
    mix.copy('node_modules/semantic-ui-css/semantic.min.js', 'assets/js');
    mix.copy('node_modules/semantic-ui-css/themes', 'assets/css/themes');

    // Copy jQuery Sources
    mix.copy('node_modules/jquery/dist/jquery.min.js', 'assets/js');

    // Copy VueJS Sources
    mix.copy('node_modules/vue/dist/vue.min.js', 'assets/js');

    // Compile our backend's LESS
    mix.less('app.less');
    
});
