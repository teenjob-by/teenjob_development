<?php

namespace App\Observers;

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
        $this->sendEmail($offer, new ModeratorOfferCreated($offer));
    }

    /**
     * Handle the offer "updated" offer.
     *
     * @param  \App\Offer  $offer
     * @return void
     */
    public function updated(Offer $offer)
    {
        $this->sendEmail($offer, new ModeratorOfferUpdated($offer));
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
