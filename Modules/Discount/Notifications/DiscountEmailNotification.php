<?php

namespace Modules\Discount\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Discount\Entities\Discount;

class DiscountEmailNotification extends Notification
{
    use Queueable;

    public $discount;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Discount $discount)
    {
        $this->discount = $discount;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('there is a new discount for you.')
                    ->line('your discount code is'.$this->discount->code)
                    ->action('Notification Action', route('products.all'));

    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
