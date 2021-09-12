<?php namespace Modules\Comment\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Modules\Comment\Events\Comment;
use Modules\Comment\Listeners\SendEmailNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * @var \string[][]
     */
    protected $listen=[
        Comment::class=>[
            SendEmailNotification::class,
        ]
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     *
     */
    public function boot()
    {
        Event::listen(
            Comment::class,
            [SendEmailNotification::class,'handle']
        );
    }


}
