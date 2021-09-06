<?php

namespace Modules\TwoFacAuth\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\TwoFacAuth\Notifications\Channel\SMSChannel;

class ActiveCodeNotification extends Notification
{
    use Queueable;

    /**
     * @var
     */
    public $code;
    /**
     * @var
     */
    public $phone_number;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($code,$phone_number)
    {
        $this->code = $code;
        $this->phone_number = $phone_number;
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

    /**
     * sms information
     *
     * @return array
     */
    public function toSMSChannel(): array
    {
        return [
            'message'=>'کد احراز هویت شما:'.'\n'.$this->code,
            'receptor'=>$this->phone_number,
        ];
    }
}
