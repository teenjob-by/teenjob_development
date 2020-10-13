<?php

namespace App\Observers;

use App\Offer;
use App\Jobs\SendTelegramNotification;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNotification;
use App\Notifications\TelegramNotification;

class OfferObserver
{
    /**
     * Handle the offer "created" offer.
     *
     * @param  \App\Offer  $offer
     * @return void
     */
    public $item_type = "offer";

    public function sendEmail(Mailable $mail)
    {
        //foreach ( as $recipient) {
        //    Mail::to($recipient)->queue(new ModeratorOfferCreated($offer));
        //}
        Mail::cc(config('mail.notification_emails'))
            ->queue($mail);
    }

    public function created(Offer $offer)
    {
        try {
            $heading = "Создано новое объявление";

            $this->sendEmail(new EmailNotification($offer, 'moderator.'. $this->item_type .'-created', $heading));
            SendTelegramNotification::dispatch($offer, new TelegramNotification('notifications.telegram.'. $this->item_type .'-notification', $heading, true, false));
            SendTelegramNotification::dispatch($offer, new TelegramNotification('notifications.telegram.'. $this->item_type .'-post', $heading, false, false));
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * Handle the offer "updated" offer.
     *
     * @param  \App\Offer  $offer
     * @return void
     */
    public function updated(Offer $offer)
    {
        try {
            $heading = "Объявление отредактировано пользователем";

            $this->sendEmail(new EmailNotification($offer, 'moderator.'. $this->item_type .'-updated', $heading));
            SendTelegramNotification::dispatch($offer, new TelegramNotification('notifications.telegram.'. $this->item_type .'-notification', $heading, true, false));
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * Handle the offer "deleted" offer.
     *
     * @param  \App\Offer  $offer
     * @return void
     */
    public function deleted(Offer $offer)
    {
        //
    }

    /**
     * Handle the offer "restored" offer.
     *
     * @param  \App\Offer  $offer
     * @return void
     */
    public function restored(Offer $offer)
    {
        //
    }

    /**
     * Handle the offer "force deleted" offer.
     *
     * @param  \App\Offer  $offer
     * @return void
     */
    public function forceDeleted(Offer $offer)
    {
        //
    }
}
