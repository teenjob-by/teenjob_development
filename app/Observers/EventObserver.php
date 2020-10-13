<?php

namespace App\Observers;

use App\Event;
use App\Jobs\SendTelegramNotification;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNotification;
use App\Notifications\TelegramNotification;

class EventObserver
{
    /**
     * Handle the event "created" event.
     *
     * @param  \App\Event  $event
     * @return void
     */
    public $item_type = "event";

    public function sendEmail(Mailable $mail)
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
            $heading = "Создано новое мероприятие";

            $this->sendEmail(new EmailNotification($event, 'moderator.'. $this->item_type .'-created', $heading));
            SendTelegramNotification::dispatch($event, new TelegramNotification('notifications.telegram.'. $this->item_type .'-notification', $heading, true, false));
            SendTelegramNotification::dispatch($event, new TelegramNotification('notifications.telegram.'. $this->item_type .'-post', $heading, false, false));
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
            $heading = "Мероприятие отредактировано пользователем";

            $this->sendEmail(new EmailNotification($event, 'moderator.'. $this->item_type .'-updated', $heading));
            SendTelegramNotification::dispatch($event, new TelegramNotification('notifications.telegram.'. $this->item_type .'-notification', $heading, true, false));
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
