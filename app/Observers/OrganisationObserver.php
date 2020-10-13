<?php

namespace App\Observers;

use App\Organisation;
use App\Jobs\SendTelegramNotification;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNotification;
use App\Notifications\TelegramNotification;

class OrganisationObserver
{
    /**
     * Handle the organisation "created" organisation.
     *
     * @param  \App\Organisation  $organisation
     * @return void
     */
    public $item_type = "organisation";

    public function sendEmail(Mailable $mail)
    {
        //foreach ( as $recipient) {
        //    Mail::to($recipient)->queue(new ModeratorOrganisationCreated($organisation));
        //}
        Mail::cc(config('mail.notification_emails'))
            ->queue($mail);
    }

    public function created(Organisation $organisation)
    {
        try {
            $heading = "Зарегистрирована новая организация";

            $this->sendEmail(new EmailNotification($organisation, 'moderator.'. $this->item_type .'-created', $heading));
            SendTelegramNotification::dispatch($organisation, new TelegramNotification('notifications.telegram.'. $this->item_type .'-notification', $heading, true, false));
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * Handle the organisation "updated" organisation.
     *
     * @param  \App\Organisation  $organisation
     * @return void
     */
    public function updated(Organisation $organisation)
    {
        try {
            $heading = "Организация запросила изменение данных";

            $this->sendEmail(new EmailNotification($organisation, 'moderator.'. $this->item_type .'-updated', $heading));
            SendTelegramNotification::dispatch($organisation, new TelegramNotification('notifications.telegram.'. $this->item_type .'-notification', $heading, true, false));
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * Handle the organisation "deleted" organisation.
     *
     * @param  \App\Organisation  $organisation
     * @return void
     */
    public function deleted(Organisation $organisation)
    {
        //
    }

    /**
     * Handle the organisation "restored" organisation.
     *
     * @param  \App\Organisation  $organisation
     * @return void
     */
    public function restored(Organisation $organisation)
    {
        //
    }

    /**
     * Handle the organisation "force deleted" organisation.
     *
     * @param  \App\Organisation  $organisation
     * @return void
     */
    public function forceDeleted(Organisation $organisation)
    {
        //
    }
}
