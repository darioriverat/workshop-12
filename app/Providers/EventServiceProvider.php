<?php

namespace App\Providers;

use App\Events\EntityCreated;
use App\Events\ModelError;
use App\Listeners\AuditEntityCreation;
use App\Listeners\LogModelError;
use App\Listeners\ResourceCreated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        EntityCreated::class => [
            ResourceCreated::class,
            AuditEntityCreation::class,
        ],
        ModelError::class => [
            LogModelError::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
