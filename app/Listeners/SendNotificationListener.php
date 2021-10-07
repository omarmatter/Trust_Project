<?php

namespace App\Listeners;

use App\Events\EventNotification;
use App\Models\setting;
use App\Models\User;
use App\Notifications\NewUser;
use App\Scopes\AdminTypeScope;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNotificationListener implements ShouldQueue
{
    use Queueable;
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

        $users = User::chunk(100, function($users) use ($user) {
            Notification::send($users, new NewUser($user));
           


        });
        }
    }
}
