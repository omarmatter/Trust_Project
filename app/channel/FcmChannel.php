<?php

namespace App\channel;

use Illuminate\Notifications\Notification;

class FcmChannel
{
    public function send($notifiable, Notification $notification)
    {

        $notification->toFcm($notifiable);
    }
}
