<?php namespace Modules\Discount\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Modules\Discount\Events\Discount;
use Modules\Discount\Listeners\SendEmailNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $listen=[
        Discount::class=>[
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

    public function boot()
    {
        Event::listen(
            Discount::class,
            [SendEmailNotification::class,'handle']
        );
    }
}
