<?php

namespace App\Listeners;

use App\Events\EntityDeleted;
use App\Traits\LoggerDataBase;
use RealRashid\SweetAlert\Facades\Alert;

class AuditEntityDeleted
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
     * @param EntityDeleted $event
     * @return void
     */
    public function handle(EntityDeleted $event)
    {
        Alert::toast(trans('actions.delete.message.success'), 'success');

        LoggerDataBase::insert(
            $event->model->getTable(),
            'Audit',
            trans('actions.delete.message.success'),
            $event->model,
        );
    }
}
