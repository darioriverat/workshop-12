<?php

namespace App\Factories\Payment;

interface PaymentInterface
{
    /**
     * Create request payment service.
     * @return mixed
     */
    public function request();

    /**
     * Returns message of payment service.
     * @return mixed
     */
    public function response();
}
