<?php

namespace Modules\OrderPayment\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    public function boot(){
        Broadcast::routes();

        require module_path('OrderPayment','Routes/channel.php');
    }
}
