<?php

namespace Modules\User\Serveices\FcmServeice;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging;
use Kreait\Firebase\Messaging\Notification;

use Kreait\Firebase\Messaging\CloudMessage;

class Fcm
{
protected  $messaging ;
    public function __construct(Messaging $messaging)
    {
        $this->messaging = $messaging;
    }
 public  function  SendFcm($deviceToken , $title ,$body){

     $deviceTokens = is_array($deviceToken) ? $deviceToken : [$deviceToken];

     $notification = Notification::fromArray([
         'title' => $title,
         'body' => $body,
     ]);
     $message = CloudMessage::new();
  $message=   $message->withNotification($notification);
//
    $x= $this->messaging->sendMulticast($message, $deviceTokens);

//     $message = CloudMessage::new();
//
//     $notification = Notification::fromArray([
//         'title' => $title,
//         'body' => $body,
//     ]);
//     $message = $message->withNotification($notification);
//
//     $x = $this->messaging->sendMulticast($message, $deviceTokens);
     Log::info(['success' => $x->successes()->count() , 'error' => $x->failures()->count()]);
//Log::info($deviceToken);
//     $message = CloudMessage::withTarget('token', 'dhS0C1WQQ_izCS8oZgl_5K:APA91bHtPUU9w9B3vuV2XZVFYccW6xVPIB65pOMOgjQHb88_BEMKVzKVJkljJcpxuROQgsoNXFVY29mBUG6UuyuwZV50HVAFLNNtg7u-nN-S5CJ4v3BXTurNFRS00fKCTXiBzhcjeAIz')
//         ->withNotification(['title' => 'Notification title', 'body' => 'Notification body']);
//
//        $this->messaging->send($message);



 }
}
