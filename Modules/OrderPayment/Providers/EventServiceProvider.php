<?php

namespace Modules\OrderPayment\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Modules\OrderPayment\Events\Paid;
use Modules\OrderPayment\Listeners\SendEmailNotification;
use Modules\OrderPayment\Listeners\SendSmsNotification;

class EventServiceProvider extends ServiceProvider
{

    protected $listen=[
        Paid::class=>[
            SendSmsNotification::class,
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
        //defining listeners for events
        Event::listen(
            Paid::class,
            [SendEmailNotification::class,'handle']
        );

        Event::listen(
            Paid::class,
            [SendSmsNotification::class,'handle']
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
