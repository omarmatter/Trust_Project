<?php

namespace App\Providers;

use App\Models\setting;
use App\Serveices\General\ImageServeice;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Modules\Menu\Repository\ProductRepository;
use Modules\Menu\Repository\ProductRepositoryInterface;
use Modules\Order\Entities\order;
use Modules\Order\Observers\OrderObserver;
use Modules\User\Entities\PersonalAccessToken;
use Modules\User\Serveices\FcmServeice\Fcm;
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
        $this->app->bind('FcmServeice', Fcm::class );
        $this->app->bind(ProductRepositoryInterface::class,ProductRepository::class);

 Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

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
        order::observe(OrderObserver::class);


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
