<?php

namespace App\ModelStates\Order\States;

class OrderShippedState extends OrderState
{
    public static string $name = 'shipped';

    public function color(): string
    {
        return 'yellow';
    }
}
