<?php

namespace App\Models;

use App\ModelStates\Order\States\OrderState;
use App\ModelStates\Payment\States\PaymentState;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\ModelStates\HasStates;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property string $cookie
 * @property int|null $auth_user
 * @property mixed $order_state
 * @property mixed $payment_state
 * @property string $payment_type
 * @property string $subtotal
 * @property string $discount
 * @property string $discount_percentage
 * @property int|null $coupon_id
 * @property string $shipping_charges
 * @property string $net_total
 * @property string $tax
 * @property string $total
 * @property string $round_off
 * @property string $payable
 * @property int $address_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Address $address
 * @property-read Collection|OrderItem[] $items
 * @property-read int|null $items_count
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order orWhereNotState(string $column, $states)
 * @method static Builder|Order orWhereState(string $column, $states)
 * @method static Builder|Order query()
 * @method static Builder|Order whereAddressId($value)
 * @method static Builder|Order whereAuthUser($value)
 * @method static Builder|Order whereCookie($value)
 * @method static Builder|Order whereCouponId($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereDiscount($value)
 * @method static Builder|Order whereDiscountPercentage($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereNetTotal($value)
 * @method static Builder|Order whereNotState(string $column, $states)
 * @method static Builder|Order whereOrderState($value)
 * @method static Builder|Order wherePayable($value)
 * @method static Builder|Order wherePaymentState($value)
 * @method static Builder|Order wherePaymentType($value)
 * @method static Builder|Order whereRoundOff($value)
 * @method static Builder|Order whereShippingCharges($value)
 * @method static Builder|Order whereState(string $column, $states)
 * @method static Builder|Order whereSubtotal($value)
 * @method static Builder|Order whereTax($value)
 * @method static Builder|Order whereTotal($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Order extends Model
{
    use HasStates;

    protected $guarded = [];

    protected $casts = [
        'order_state' => OrderState::class,
        'payment_state' => PaymentState::class,
    ];

    /*Relations starts*/

    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * @return BelongsTo
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /*Relations ends*/
}
