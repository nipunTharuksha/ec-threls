<?php

namespace App\ModelStates\Payment\States;

use Spatie\ModelStates\Exceptions\InvalidConfig;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class PaymentState extends State
{
    /**
     * @return StateConfig
     * @throws InvalidConfig
     */
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(PaymentPendingState::class)
            ->allowTransition(PaymentPendingState::class, PaymentDeclinedState::class)
            ->allowTransition(PaymentPendingState::class, PaymentAcceptedState::class);
    }

}
