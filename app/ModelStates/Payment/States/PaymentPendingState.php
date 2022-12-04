<?php

namespace App\ModelStates\Payment\States;

class PaymentPendingState extends PaymentState
{
    public static string $name = 'pending';

    public function color(): string
    {
        return 'yellow';
    }
}
