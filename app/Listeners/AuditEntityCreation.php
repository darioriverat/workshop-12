<?php

namespace App\Listeners;

use App\Events\EntityCreated;
use App\Traits\LoggerDataBase;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AuditEntityCreation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param EntityCreated $event
     * @return void
     */
    public function handle(EntityCreated $event)
    {
        LoggerDataBase::insert(
            $event->model->getTable(),
            'Audit',
            trans('categories.message.error', $event->model->toArray())
        );
    }
}
