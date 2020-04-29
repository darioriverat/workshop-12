<?php

namespace App\Listeners;

use App\Events\EntityCreated;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class ResourceCreated
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
        Log::info('Entity Create', ['model' => $event->model->toArray()]);
        Alert::toast(trans('actions.message.success'), 'success');
    }
}
