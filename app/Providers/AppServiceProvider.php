<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Schema;
use App\Event;
use App\Offer;
use App\Organisation;
use App\Observers\EventObserver;
use App\Observers\OfferObserver;
use App\Observers\OrganisationObserver;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Event::observe(EventObserver::class);
        Offer::observe(OfferObserver::class);
        Organisation::observe(OrganisationObserver::class);

        VerifyEmail::toMailUsing(function ($notifiable,$url){
            $mail = new MailMessage;
            $mail->subject('Подтверждение адреса');
            $mail->markdown('emails.verify-email', ['url' => $url]);
            return $mail;
        });


    }
}
