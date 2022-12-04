<?php

namespace App\ModelStates\Order\States;

use Spatie\ModelStates\Exceptions\InvalidConfig;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class OrderState extends State
{
    /**
     * @return StateConfig
     * @throws InvalidConfig
     */
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(OrderWaitingForApprovalState::class)
            ->allowTransition(OrderWaitingForApprovalState::class, OrderApprovedState::class)
            ->allowTransition(OrderWaitingForApprovalState::class, OrderDeclinedState::class)
            ->allowTransition(OrderApprovedState::class, OrderShippedState::class)
            ->allowTransition(OrderShippedState::class, OrderDeliveredState::class)
            ->allowTransition(OrderDeliveredState::class, OrderCompletedState::class);
    }

}
