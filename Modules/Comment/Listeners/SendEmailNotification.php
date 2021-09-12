<?php

namespace Modules\Comment\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Comment\Events\Comment;
use Modules\Comment\Notifications\CommentEmailNotification;
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
     * @param Comment $event
     * @return void
     */
    public function handle(Comment $event)
    {
        $comment = $event->comment;
        $user = $comment->user;
        $notification = Notification::where('title','کامنت')->first();
        $channel = Channel::where('title','mail')->first();
        //check if user have activated notification for comment
        if($user->checkNotificationChannel($notification,$channel)){
            $user->notify(new CommentEmailNotification($comment));
        }

    }
}
