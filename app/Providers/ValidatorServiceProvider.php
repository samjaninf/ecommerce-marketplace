<?php namespace Koolbeans\Providers;

use GuzzleHttp\Client;
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

        $this->app->make('validator')->extend('google_recaptcha', function ($attribute, $value, $parameters) {
            if ($attribute === 'g-recaptcha-response') {
                $client   = new Client();
                $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
                    'body' => ['secret' => '6LdFiAcTAAAAAI1fANc4qUrjnlrM54q7czAGkr7O', 'response' => $value],
                ]);

                return $response->json()['success'];
            }

            return false;
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
