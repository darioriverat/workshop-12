<?php

namespace App\Listeners;

use App\Events\EntityCreated;
use App\Traits\LoggerDataBase;
use RealRashid\SweetAlert\Facades\Alert;

class AuditEntityCreation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param EntityCreated $event
     * @return void
     */
    public function handle(EntityCreated $event)
    {
        Alert::toast(trans('actions.create.message.success'), 'success');

        LoggerDataBase::insert(
            $event->model->getTable(),
            'Audit',
            trans('actions.create.message.success'),
            $event->model,
        );
    }
}
