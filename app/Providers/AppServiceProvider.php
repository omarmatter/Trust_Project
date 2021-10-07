<?php

namespace App\Providers;

use App\Models\setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
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
