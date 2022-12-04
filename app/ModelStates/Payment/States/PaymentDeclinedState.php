<?php

namespace App\ModelStates\Payment\States;

class PaymentDeclinedState extends PaymentState
{
    public static string $name = 'declined';

    public function color(): string
    {
        return 'red';
    }
}
