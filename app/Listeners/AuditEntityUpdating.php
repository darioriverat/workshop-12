<?php

namespace App\Listeners;

use App\Events\EntityUpdating;
use App\Traits\LoggerDataBase;
use RealRashid\SweetAlert\Facades\Alert;

class AuditEntityUpdating
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
     * @param EntityUpdating $event
     * @return void
     */
    public function handle(EntityUpdating $event)
    {
        Alert::toast(trans('actions.edit.message.success'), 'success');

        LoggerDataBase::insert(
            $event->model->getTable(),
            'Audit',
            trans('actions.edit.message.success'),
            $event->model
        );
    }
}
