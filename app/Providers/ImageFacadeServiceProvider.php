<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ImageFacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ImageServeice', function()
    {
        return new ImageServeice();
    });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
