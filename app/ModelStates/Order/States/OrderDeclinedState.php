<?php

namespace App\ModelStates\Order\States;

class OrderDeclinedState extends OrderState
{
    public static string $name = 'declined';

    public function color(): string
    {
        return 'red';
    }
}
