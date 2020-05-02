<?php

namespace App\Factories;

use InvalidArgumentException;

interface PaymentFactory
{
    /**
     * @param $type
     * @return PaymentInterface
     * @throws InvalidArgumentException
     */
    public function create($type);
}
