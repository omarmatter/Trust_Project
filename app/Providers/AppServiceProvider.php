<?php

namespace App\Providers;

use App\Models\setting;
use App\Serveices\General\ImageServeice;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Modules\User\Serveices\SmsServeice\cequensSms;
use Modules\User\Serveices\SmsServeice\smsInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ImageServeice',ImageServeice::class);
        $this->app->bind('cequensSms',cequensSms::class);


//        $this->app->bind(smsInterface::class, function($app) {
//
//                return new cequensSms();
//            });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $settings = Cache::get('app-settings');
        if (!$settings) {

            $settings = setting::all();
            Cache::put('app-settings', $settings);
        }

        foreach ($settings as $setting) {
            config()->set($setting->key, $setting->value);
        }
    }
}
