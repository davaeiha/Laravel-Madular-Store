<?php

namespace Modules\OrderPayment\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Notification\Entities\Channel;
use Modules\Notification\Entities\Notification;
use Modules\OrderPayment\Events\Paid;
use Modules\OrderPayment\Notifications\PaidSmsNotification;

class SendSmsNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Paid $event
     * @return void
     */
    public function handle(Paid $event)
    {
        $user = $event->payment->order->user;
        $tracking_serial = $event->payment->order->tracking_serial;
        $notification = Notification::where('title','پرداخت')->first();
        $channel = Channel::where('title','sms')->first();
        //send notification if user have activated
        if($user->checkNotificationChannel($notification,$channel)){
            $user->notify(new PaidSmsNotification($user->phone_number,$tracking_serial));
        }

    }
}
