<?php

namespace App\Listeners;

use App\Events\CreateOrder;
use JetBrains\PhpStorm\NoReturn;

class ClearCheckout
{
    /**
     * Handle the event.
     */
    #[NoReturn] public function handle(CreateOrder $event): void
    {
        $event->order->user->checkout()->delete();
    }
}
