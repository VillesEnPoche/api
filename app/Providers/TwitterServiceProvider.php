<?php

namespace App\Providers;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\ServiceProvider;

class TwitterServiceProvider extends ServiceProvider
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
        $this->app->singleton('twitter', function ($app) {
            return new TwitterOAuth(
                config('twitter.config.consumer_key'),
                config('twitter.config.consumer_secret'),
                config('twitter.config.access_token'),
                config('twitter.config.access_token_secret')
            );
        });
    }
}
