<?php

namespace App\Listeners;

use App\Events\GetResponsePayment;
use App\Factories\Payment\PaymentGateway;

class RequestResponse
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
     * @param GetResponsePayment $event
     * @return void
     */
    public function handle(GetResponsePayment $event)
    {
        if ($event->model->process_url) {
            $service = (new PaymentGateway($event->model))->create('PaymentPlaceToPay')->response();
            $event->model->update(['status' => $service]);
        }
    }
}
