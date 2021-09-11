<?php

namespace Modules\OrderPayment\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\OrderPayment\Notifications\Channels\SMSChannel;

class PaidSmsNotification extends Notification
{
    use Queueable;


    /**
     * @var
     */
    protected $phone_number;


    protected $tracking_serial;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($phone_number,$tracking_serial)
    {
        $this->phone_number = $phone_number;
        $this->tracking_serial = $tracking_serial;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return [SMSChannel::class];
    }

    public function toSMSChannel(): array
    {
            return [
                'message'=>'خرید شما با موفقیت انجام شد. '.'\n'.'کد رهگیری شما'.'\n'.$this->tracking_serial,
                'receptor'=>$this->phone_number,
            ];
    }

}
