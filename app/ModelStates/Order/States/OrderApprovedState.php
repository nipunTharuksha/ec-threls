<?php

namespace App\ModelStates\Order\States;

class OrderApprovedState extends OrderState
{
    public static string $name = 'approved';

    public function color(): string
    {
        return 'blue';
    }
}
