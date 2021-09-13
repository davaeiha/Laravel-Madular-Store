<?php

namespace Modules\Discount\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Modules\Discount\Events\Discount;
use Modules\Discount\Notifications\DiscountEmailNotification;
use Modules\Notification\Entities\Channel;
use Modules\Notification\Entities\Notification;

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
     * @param Discount $event
     * @return void
     */
    public function handle(Discount $event)
    {
        $discount = $event->discount;
        $users = $event->users;
        //notification and channel
        $notification = Notification::where('title','تخفیف')->first();
        $channel = Channel::where('title','mail')->first();
        //notify users if they have activated discount notification
        $users->each(function ($user) use ($channel, $notification, $discount) {
            if($user->checkNotificationChannel($notification,$channel)){
                //notify user via email
                $user->notify(new DiscountEmailNotification($discount));
            }
        });
    }
}
