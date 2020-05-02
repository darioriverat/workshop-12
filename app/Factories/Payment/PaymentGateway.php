<?php

namespace App\Factories\Payment;

use App\Factories\PaymentFactory;
use InvalidArgumentException;

class PaymentGateway implements PaymentFactory
{
    private $payment;

    public function __construct($payment)
    {
        $this->payment = $payment;
    }

    public function create($type)
    {
        $PaymentClass = __NAMESPACE__ . '\\' . $type;

        if (!class_exists($PaymentClass)) {
            throw new InvalidArgumentException("Class {$PaymentClass} does not exist");
        }

        return new $PaymentClass($this->payment);
    }
}
