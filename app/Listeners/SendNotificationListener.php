<?php

namespace App\Listeners;

use App\Events\EventNotification;
use App\Models\User;
use App\Notifications\NewUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNotificationListener
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
        $user = $event->user;

        $users = User::where('roles', '1')->Where('receive_notify', '1')->get();

        Notification::send($users, new NewUser($user));
    }
}
