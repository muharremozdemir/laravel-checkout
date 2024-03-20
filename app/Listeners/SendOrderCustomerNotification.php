<?php

namespace App\Listeners;

use App\Events\CreateOrder;
use App\Jobs\CreateOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderCustomerNotification implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(CreateOrder $event): void
    {
        CreateOrderNotification::dispatch($event);
        //Sadece müşteri tarafında yapılacak işlemler için kullanılabilir
    }
}
