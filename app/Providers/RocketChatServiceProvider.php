<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class RocketChatServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('rocket', function ($app) {
            if (! empty(getenv('ROCKET_CHAT_WEBHOOK'))) {
                $webhook = new Client([
                    'base_uri' => getenv('ROCKET_CHAT_WEBHOOK'),
                    'timeout' => 10.0,
                ]);

                return $webhook;
            }

            return '';
        });
    }
}
