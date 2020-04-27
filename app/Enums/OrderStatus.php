<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static CREATED()
 * @method static static PAYED()
 * @method static static PENDING()
 * @method static static REJECTED()
 */
final class OrderStatus extends Enum
{
    const CREATED =  'CREATED';
    const PAYED =   'PAYED';
    const PENDING = 'PENDING';
    const REJECTED = 'REJECTED';
}
