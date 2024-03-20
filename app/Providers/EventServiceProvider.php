<?php

namespace App\Providers;

use App\Events\CreateOrder;
use App\Events\UpdateOrder;
use App\Listeners\ClearCheckout;
use App\Listeners\SendOrderAdminNotification;
use App\Listeners\SendOrderCustomerNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CreateOrder::class => [
            ClearCheckout::class,
            SendOrderCustomerNotification::class,
            SendOrderAdminNotification::class,
        ],
        UpdateOrder::class => [
            SendOrderCustomerNotification::class,
            SendOrderAdminNotification::class,
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
