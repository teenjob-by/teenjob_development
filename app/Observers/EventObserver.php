<?php

namespace App\Observers;

use App\Event;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use App\Mail\ModeratorEventCreated;
use App\Mail\ModeratorEventUpdated;

class EventObserver
{
    /**
     * Handle the event "created" event.
     *
     * @param  \App\Event  $event
     * @return void
     */

    public function sendEmail(Event $event, Mailable $mail)
    {
        //foreach ( as $recipient) {
        //    Mail::to($recipient)->queue(new ModeratorEventCreated($event));
        //}
        Mail::cc(config('mail.notification_emails'))
            ->queue($mail);

    }

    public function created(Event $event)
    {
            $this->sendEmail($event, new ModeratorEventCreated($event));
    }

    /**
     * Handle the event "updated" event.
     *
     * @param  \App\Event  $event
     * @return void
     */
    public function updated(Event $event)
    {
        $this->sendEmail($event, new ModeratorEventUpdated($event));
    }

    /**
     * Handle the event "deleted" event.
     *
     * @param  \App\Event  $event
     * @return void
     */
    public function deleted(Event $event)
    {
        //
    }

    /**
     * Handle the event "restored" event.
     *
     * @param  \App\Event  $event
     * @return void
     */
    public function restored(Event $event)
    {
        //
    }

    /**
     * Handle the event "force deleted" event.
     *
     * @param  \App\Event  $event
     * @return void
     */
    public function forceDeleted(Event $event)
    {
        //
    }
}
