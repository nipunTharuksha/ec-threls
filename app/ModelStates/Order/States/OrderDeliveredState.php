<?php

namespace App\ModelStates\Order\States;

class OrderDeliveredState extends OrderState
{
    public static string $name = 'delivered';

    public function color(): string
    {
        return 'yellow';
    }
}
