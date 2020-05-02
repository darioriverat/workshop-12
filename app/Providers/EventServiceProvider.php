<?php

namespace App\Providers;

use App\Events\EntityCreated;
use App\Events\EntityDeleted;
use App\Events\EntityUpdating;
use App\Events\GetResponsePayment;
use App\Events\ModelError;
use App\Events\PayOrder;
use App\Listeners\AuditEntityCreation;
use App\Listeners\AuditEntityDeleted;
use App\Listeners\AuditEntityUpdating;
use App\Listeners\LogModelError;
use App\Listeners\RequestRedirect;
use App\Listeners\RequestResponse;
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
        PayOrder::class => [
            RequestRedirect::class,
        ],
        GetResponsePayment::class => [
            RequestResponse::class,
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
