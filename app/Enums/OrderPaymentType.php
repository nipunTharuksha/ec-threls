<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static COD()
 * @method static static CP()
 */
final class OrderPaymentType extends Enum
{
    const COD = 'COD'; // Cash on delivery
    const CP = 'CP'; // Card payment
}
