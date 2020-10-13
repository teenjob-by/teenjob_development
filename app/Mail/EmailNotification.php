<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $view;
    public $heading;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($item, $view, $heading)
    {
        $this->data = $item;
        $this->view = $view;
        $this->heading = $heading;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                    ->from(config('mail.notification_from'))
                    ->subject($this->heading)
                    ->view('emails.'.$this->view, array('heading' => $this->heading) );
    }
}
