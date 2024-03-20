<?php

namespace App\Listeners;

use App\Events\CreateOrder;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderAdminNotification implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(CreateOrder $event): void
    {
        //Sadece admin tarafında yapılacak işlemler için kullanılabilir.
    }
}
