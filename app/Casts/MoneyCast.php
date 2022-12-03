<?php

namespace App\Casts;

use Brick\Money\Exception\UnknownCurrencyException;
use Brick\Money\Money;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class MoneyCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return Money
     * @throws UnknownCurrencyException
     */
    public function get($model, string $key, $value, array $attributes): Money
    {
        return Money::ofMinor($attributes['price'], $attributes['currency']);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes): mixed
    {
        if (!$value instanceof Money) {
            return $value;
        }
        return $value->getMinorAmount()->toInt();
    }
}
