<?php

namespace App\Listeners;

use App\Enums\OrderStatus;
use App\Events\PayOrder;
use App\Factories\Payment\PaymentGateway;
use App\Order;
use RealRashid\SweetAlert\Facades\Alert;

class RequestRedirect
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
     * @param PayOrder $event
     * @return void
     */
    public function handle(PayOrder $event)
    {
        if ($event->model->process_url) {
            return true;
        } else {
            $service = (new PaymentGateway($event->model))->create('PaymentPlaceToPay')->request();
            if ($service['status']) {
                Order::findOrFail($event->model->id)->update(['status' => OrderStatus::PENDING,
                    'request_id' => $service['response']->request_id,
                    'process_url' => $service['response']->process_url,
                ]);
                return $service->status;
            } else {
                Alert::toast($service['message'], 'error');
                return false;
            }
        }
    }
}
