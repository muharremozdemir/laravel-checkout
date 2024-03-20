<?php

namespace App\Jobs;

use App\Models\ArchiveOrders;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeniedToArchive implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $deniedOrders;

    public function __construct($deniedOrders)
    {
        $this->deniedOrders = $deniedOrders;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->deniedOrders as $deniedOrder){
            ArchiveOrders::query()->create(array_merge($deniedOrder->toArray(), ['status' => 'Archive', 'order_id' => $deniedOrder->id]));
            $deniedOrder->delete();
        }
    }
}
