<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateOrder
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public mixed $order;

    /**
     * Create a new event instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
    }
}
