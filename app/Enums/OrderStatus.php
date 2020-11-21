<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static CREATED()
 * @method static static PAYED()
 * @method static static PENDING()
 * @method static static REJECTED()
 * @method static static APPROVED()
 */
final class OrderStatus extends Enum
{
    public const CREATED = 'CREATED';
    public const PAYED = 'PAYED';
    public const PENDING = 'PENDING';
    public const REJECTED = 'REJECTED';
    public const APPROVED = 'APPROVED';
}
