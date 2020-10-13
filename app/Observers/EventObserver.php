<?php

namespace App\Observers;

use App\Event;
use App\Jobs\SendTelegramNotification;
use App\Notifications\TelegramEventCreated;
use App\Notifications\TelegramEventUpdated;
use App\Notifications\TelegramPostEvent;
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
        //    Mail::to($recipient)->queue(new ModeratorOfferCreated($offer));
        //}
        Mail::cc(config('mail.notification_emails'))
            ->queue($mail);

    }

    public function created(Event $event)
    {

        try {
            $this->sendEmail($event, new ModeratorEventCreated($event));
            SendTelegramNotification::dispatch($event, new TelegramEventCreated('notifications.telegram.event-notification'));
            SendTelegramNotification::dispatch($event, new TelegramPostEvent('notifications.telegram.event-post'));
        } catch (Throwable $e) {
            return false;
        }

    }

    /**
     * Handle the event "updated" event.
     *
     * @param  \App\Event  $event
     * @return void
     */
    public function updated(Event $event)
    {
        try {
            $this->sendEmail($event, new ModeratorEventUpdated($event));
            SendTelegramNotification::dispatch($event, new TelegramEventUpdated('notifications.telegram.event-notification'));
        } catch (Throwable $e) {
            return false;
        }
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
