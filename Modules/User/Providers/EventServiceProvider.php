<?php

namespace Modules\User\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\User\Entities\User;
use Modules\User\Events\EventNotification;
use Modules\User\Listeners\SendNotificationListener;
use Modules\User\Observers\UserObserver;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        EventNotification::class => [
            SendNotificationListener::class
        ]
        ];

    public function boot()
    {
        User::observe(UserObserver::class);
    }
}
