var elixir = require('laravel-elixir');

require('laravel-elixir-imagemin');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
    mix.less('app.less');
    mix.coffee();
    mix.imagemin();
    mix.scripts(['bootstrap-switch.js'], 'public/js/vendor.js');

    mix.version([
        'css/app.css',
        'js/app.js',
        'js/user.js',
        'js/order.js',
        'js/modal.js',
        'js/gmaps.js',
        'js/admin.js',
        'js/shop_owner.js',
        'js/vendor.js'
    ]);
});
