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
    mix.less('app.less')
        .coffee()
        .imagemin()
        .scripts(['bootstrap-switch.js', 'datetimepicker.js'], 'public/js/vendor.js')
        .styles(['datetimepicker.css'], 'public/css/vendor.css')
        .version([
            'css/app.css',
            'css/vendor.css',
            'js/app.js',
            'js/vendor.js'
        ]);
});
