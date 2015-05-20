<?php namespace Koolbeans\Providers;

use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->make('validator')->extend('google_place_id', function ($attribute, $value, $parameters) {
            return $this->app->make('places')->has($value);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
