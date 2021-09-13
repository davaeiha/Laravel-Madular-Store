<?php

namespace Modules\Discount\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Discount\Entities\Discount as DiscountModel;

class Discount
{
    use SerializesModels;

    /**
     * @var DiscountModel
     */
    public $discount;
    /**
     * @var
     */
    public $users;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DiscountModel $discount,$users)
    {
        $this->discount= $discount;
        $this->users = $users;
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
