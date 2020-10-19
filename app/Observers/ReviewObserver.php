<?php

namespace App\Observers;

use App\Review;
use App\Jobs\SendTelegramNotification;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNotification;
use App\Notifications\TelegramNotification;

class ReviewObserver
{
    /**
     * Handle the review "created" review.
     *
     * @param  \App\Review  $review
     * @return void
     */
    public $item_type = "review";

    public function sendEmail(Mailable $mail)
    {
        //foreach ( as $recipient) {
        //    Mail::to($recipient)->queue(new ModeratorReviewCreated($review));
        //}
        Mail::cc(config('mail.notification_emails'))
            ->queue($mail);
    }

    public function created(Review $review)
    {
        try {
            $heading = "Добавлен новый отзыв";

            $this->sendEmail(new EmailNotification($review, 'moderator.'. $this->item_type .'-created', $heading));
            SendTelegramNotification::dispatch($review, new TelegramNotification('notifications.telegram.'. $this->item_type .'-notification', $heading, true, false));
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * Handle the review "updated" review.
     *
     * @param  \App\Review  $review
     * @return void
     */
    public function updated(Review $review)
    {
        try {
            $heading = "Отзыв отредактирован пользователем";

            $this->sendEmail(new EmailNotification($review, 'moderator.'. $this->item_type .'-updated', $heading));
            SendTelegramNotification::dispatch($review, new TelegramNotification('notifications.telegram.'. $this->item_type .'-notification', $heading, true, false));
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * Handle the review "deleted" review.
     *
     * @param  \App\Review  $review
     * @return void
     */
    public function deleted(Review $review)
    {
        //
    }

    /**
     * Handle the review "restored" review.
     *
     * @param  \App\Review  $review
     * @return void
     */
    public function restored(Review $review)
    {
        //
    }

    /**
     * Handle the review "force deleted" review.
     *
     * @param  \App\Review  $review
     * @return void
     */
    public function forceDeleted(Review $review)
    {
        //
    }
}
