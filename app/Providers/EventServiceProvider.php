<?php

namespace App\Providers;

use App\Events\EntityCreated;
use App\Events\EntityDeleted;
use App\Events\EntityUpdating;
use App\Events\ModelError;
use App\Listeners\AuditEntityCreation;
use App\Listeners\AuditEntityDeleted;
use App\Listeners\AuditEntityUpdating;
use App\Listeners\LogModelError;
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
            AuditEntityCreation::class,
        ],
        EntityUpdating::class => [
            AuditEntityUpdating::class,
        ],
        EntityDeleted::class => [
            AuditEntityDeleted::class,
        ],
        ModelError::class => [
            LogModelError::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
