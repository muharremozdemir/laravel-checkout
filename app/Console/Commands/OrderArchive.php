<?php

namespace App\Console\Commands;

use App\Jobs\DeniedToArchive;
use App\Models\Order;
use Illuminate\Console\Command;

class OrderArchive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:order-archive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Moves rejected orders to archive';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deniedOrders = Order::query()->where('status', 'Denied')->get();
        DeniedToArchive::dispatch($deniedOrders);
    }
}
