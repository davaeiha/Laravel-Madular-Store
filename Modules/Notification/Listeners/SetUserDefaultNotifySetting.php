<?php

namespace Modules\Notification\Listeners;


use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Notification\Entities\Notification;

class SetUserDefaultNotifySetting
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
     * add default notification and channels
     *
     * @param Registered $event
     * @return void
     */
    public function handle(Registered $event)
    {

        $notifications = Notification::all();

        $notifications->each(function ($notification) use ($event) {
            $notification->channels()->each(function ($channel) use ($notification, $event) {
                $event->user->notificationRelations()->attach($notification->id,['channel_id'=>$channel->id]);
            });
        });

    }
}
