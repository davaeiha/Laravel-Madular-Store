<?php

namespace Modules\OrderPayment\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Notification\Entities\Channel;
use Modules\Notification\Entities\Notification;
use Modules\OrderPayment\Events\Paid;
use Modules\OrderPayment\Notifications\PaidEmailNotification;

class SendEmailNotification
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
        $payment = $event->payment;
        $user = $payment->order->user;
        $notification = Notification::where('title','پرداخت')->first();
        $channel = Channel::where('title','mail')->first();
        //send notification if user have activated
        if($user->checkNotificationChannel($notification,$channel)){
            $user->notify(new PaidEmailNotification($payment->price));
        }

    }
}
