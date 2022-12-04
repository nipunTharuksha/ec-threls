<?php

namespace App\ModelStates\Payment\States;

class PaymentAcceptedState extends PaymentState
{
    public static string $name = 'completed';

    public function color(): string
    {
        return 'green';
    }
}
