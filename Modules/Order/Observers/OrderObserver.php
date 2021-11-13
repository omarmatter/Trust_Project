<?php

namespace Modules\Order\Observers;


use Illuminate\Support\Facades\Log;
use Modules\Order\Entities\order;
use Modules\Order\Notifications\ChangeStatusNotification;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *

     * @return void
     */
    public function created(order $order)
    {
//        Log::info('ddd');
    }

    /**
     * Handle the Order "updated" event.
     *
     * @return void
     */
    public function updated(Order $order)
    {
       Log::info('updated');
        $order->user->notify(new ChangeStatusNotification());
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
