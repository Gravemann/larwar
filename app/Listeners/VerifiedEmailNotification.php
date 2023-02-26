<?php

namespace App\Listeners;

use App\Notifications\EmailVerifiedSuccess;
use Illuminate\Auth\Events\Verified;

class VerifiedEmailNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Verified  $event
     *
     * @return void
     */
    public function handle(Verified $event)
    {
        $event->user->notify(new EmailVerifiedSuccess());
    }
}
