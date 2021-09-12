<?php

namespace Modules\Comment\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CommentEmailNotification extends Notification
{
    use Queueable;

    /**
     * @var
     */
    public $comment;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
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
        if($this->comment->parent_id != 0 ){
            //send email for user to tell
            return (new MailMessage)
                ->line('your comment have been replied')
                ->line('the comment:'.$this->comment->comment)
                ->action('see the replied comment', route('products.single',$this->comment->commentable->id));
        }else{
            return (new MailMessage)
                ->line('your comment have been approved')
                ->line('the comment:'.$this->comment->comment)
                ->action('see the replied comment', route('products.single',$this->comment->commentable->id));
        }


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
