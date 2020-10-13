<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramOfferCreated extends Notification
{
    use Queueable;

    public $view;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($view)
    {
        $this->view = $view;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($offer)
    {
        return TelegramMessage::create()
            ->to(config('services.telegram-notifications-channel'))
            ->view($this->view, array('data' => $offer), array('heading' => "Создано объявление"))
            ->options(['parse_mode' => 'Markdown'])
            ->button('Модерировать', $offer->moderatorUrl());
    }

}
