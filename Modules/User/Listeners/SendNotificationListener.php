<?php

namespace Modules\User\Listeners;

use App\Notifications\NewUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Modules\User\Entities\User;
use Modules\User\Events\EventNotification;
use Modules\User\Notifications\NewUserNotifictation;
use Modules\User\Serveices\SmsServeice\cequensSms;

class SendNotificationListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public $user;
    public function __construct(User $user)
    {

        $this->user = $user;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EventNotification $event)
    {




        if(config('notify')){


            $user= $event->user;
            $users = User::IsAdmin()->chunk(100, function($users) use ($user) {
                $channel = new cequensSms();

                Notification::send($users, new NewUserNotifictation($user));

            });
        }
    }
}
