<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramNotification extends Notification
{
    use Queueable;

    public $view;
    public $heading;
    public $isModerationLink;
    public $isOpenLink;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($view, $heading, $isModerationLink = false, $isOpenLink = false)
    {
        $this->view = $view;
        $this->heading = $heading;
        $this->isModerationLink = $isModerationLink;
        $this->isOpenLink = $isOpenLink;
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

    public function toTelegram($item)
    {
        $TelegramMessage = TelegramMessage::create()
            ->to(config('services.telegram-notifications-channel'));
        $TelegramMessage
            ->view($this->view, array('data' => $item), array('heading' => $this->heading))
            ->options(['parse_mode' => 'Markdown']);

        if($this->isModerationLink) {
            $TelegramMessage->button('Модерировать', $item->moderatorUrl());
        }

        if($this->isOpenLink) {
            $TelegramMessage->button('Просмотреть', $item->url());
        }

        return $TelegramMessage;
    }

}
