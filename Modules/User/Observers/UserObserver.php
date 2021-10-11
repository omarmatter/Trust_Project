<?php

namespace Modules\User\Observers;

use Modules\User\Entities\User;
use Modules\User\Events\EventNotification;


class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return void
     */
    public function created(User $user)
    {

        event(new EventNotification($user));

    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
