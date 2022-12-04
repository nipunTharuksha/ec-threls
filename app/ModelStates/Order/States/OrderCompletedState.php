<?php

namespace App\ModelStates\Order\States;

class OrderCompletedState extends OrderState
{
    public static string $name = 'completed';

    public function color(): string
    {
        return 'green';
    }
}
