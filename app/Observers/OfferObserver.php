<?php

namespace App\Observers;

use App\Jobs\SendTelegramNotification;
use App\Notifications\TelegramOfferCreated;
use App\Notifications\TelegramOfferUpdated;
use App\Notifications\TelegramPostOffer;
use App\Offer;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use App\Mail\ModeratorOfferCreated;
use App\Mail\ModeratorOfferUpdated;

class OfferObserver
{
    /**
     * Handle the offer "created" offer.
     *
     * @param  \App\Offer  $offer
     * @return void
     */

    public function sendEmail(Offer $offer, Mailable $mail)
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
                $this->sendEmail($offer, new ModeratorOfferCreated($offer));
                SendTelegramNotification::dispatch($offer, new TelegramOfferCreated('notifications.telegram.offer-notification'));
                SendTelegramNotification::dispatch($offer, new TelegramPostOffer('notifications.telegram.offer-post'));
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
            $this->sendEmail($offer, new ModeratorOfferUpdated($offer));
            SendTelegramNotification::dispatch($offer, new TelegramOfferUpdated('notifications.telegram.offer-notification'));
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
