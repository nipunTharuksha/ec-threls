<?php

namespace App\ModelStates\Order\States;

class OrderWaitingForApprovalState extends OrderState
{
    public static string $name = 'waiting for approval';

    public function color(): string
    {
        return 'yellow';
    }
}
