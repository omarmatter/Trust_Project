<?php

namespace Modules\Order\Notifications;

//use App\channel\FcmChannel;
use App\channel\FcmChannel;
use App\Facades\FcmFacade;
use App\Facades\smsFacade;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;



class ChangeStatusNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database',
            FcmChannel::class
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', 'https://laravel.com')
            ->line('Thank you for using our application!');
    }


    public function toFcm($notifiable)
    {
        Log::info('fcm');

        return FcmFacade::SendFcm($notifiable->tokens()->pluck('FcmToken')->toArray(),'Change Order Status','Change Order Status');


    }



    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {

             return [
                 'title' => 'Change Status ',
                 'body' => 'change Status ' ,


        ];
    }
}
