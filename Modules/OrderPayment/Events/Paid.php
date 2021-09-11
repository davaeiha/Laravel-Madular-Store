<?php

namespace Modules\OrderPayment\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Modules\OrderPayment\Entities\Payment;

class Paid
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

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
