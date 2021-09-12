<?php

namespace Modules\OrderPayment\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Modules\OrderPayment\Entities\Payment;

class Paid implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * @var Payment
     */
    public $payment;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function broadcastOn()
    {
        // TODO: Implement broadcastOn() method.
    }
}
