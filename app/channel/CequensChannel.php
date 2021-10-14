<?php

namespace App\channel;

use App\Facades\smsFacade;
use App\Serveices\General\ImageServeice;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Modules\User\Serveices\SmsServeice\cequensSms;

class cequensChannel
{
    public function send($notifiable, Notification $notification)
    {

        $notification->toCequencSms($notifiable);
    }
}
