<?php

namespace App\Listeners;

use App\Events\EntityCreated;
use App\Events\ModelError;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class LogModelError
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
     * @param ModelError $event
     * @return void
     */
    public function handle(ModelError $event)
    {
        Log::error('Entity Creation error', [
            'model' => $event->model->toArray(),
            'errorDescription' => $event->errorDescription,
        ]);

        Alert::toast(trans('actions.message.error'), 'error');
    }
}
