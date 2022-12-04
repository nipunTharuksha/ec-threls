<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Order\UserOrderPlaceRequest;
use App\Http\Resources\DataResourceCollection;
use App\Models\Address;
use App\Models\Order;
use DB;
use Freshbitsweb\LaravelCartManager\Models\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

class UserOrderController extends Controller
{
    /**
     * @throws Throwable
     */
    public function placeAnOrder(UserOrderPlaceRequest $request): JsonResponse
    {
        $addressData = $request->validated();
        $cart = Cart::whereAuthUser(auth()->id())->with('items')->first();

        if (!$cart) {
            throw ValidationException::withMessages(['Please add products into cart first.']);
        }

        DB::transaction(function () use ($cart, $addressData) {
            $address = Address::create($addressData);
            //Create a new order
            $Order = Order::create(
                collect($cart)->except(['id', 'created_at', 'updated_at', 'items'])->put(
                    'address_id',
                    $address->id
                )->toArray()
            );

            //Assign cart items to order
            foreach ($cart->items as $item) {
                $Order->items()->create(
                    collect($item)->only(['name', 'price', 'quantity', 'created_at', 'updated_at'])->toArray()
                );
            }

            //Destroy cart
            cart()->setUser(auth()->id());
            cart()->clear();
        });

        return $this->respondCreated();
    }

    /**
     * @return DataResourceCollection
     */
    public function myOrders(): DataResourceCollection
    {
        $ordersQuery = QueryBuilder::for(
            Order::with('items:id,name,price,quantity,order_id')
                ->with('address:id,full_name,address_line_1,address_line_2,city,post_code,country')
        )->select([
            'id',
            'order_state',
            'payment_state',
            'payment_type',
            'subtotal',
            'discount',
            'discount_percentage',
            'coupon_id',
            'shipping_charges',
            'net_total',
            'tax',
            'total',
            'round_off',
            'payable',
            'address_id',
            'created_at'
        ])->allowedFilters([
            AllowedFilter::callback('search', function ($query, $value) {
                $query->where(function ($query) use ($value) {
                    $query->where('order_state', 'like', '%' . $value . '%')
                        ->orWhere('payment_state', 'like', '%' . $value . '%')
                        ->orWhere('payment_type', 'like', '%' . $value . '%')
                        ->orWhere('subtotal', 'like', '%' . $value . '%')
                        ->orWhere('discount', 'like', '%' . $value . '%')
                        ->orWhere('discount_percentage', 'like', '%' . $value . '%')
                        ->orWhere('shipping_charges', 'like', '%' . $value . '%')
                        ->orWhere('net_total', 'like', '%' . $value . '%')
                        ->orWhere('tax', 'like', '%' . $value . '%')
                        ->orWhere('total', 'like', '%' . $value . '%')
                        ->orWhere('round_off', 'like', '%' . $value . '%')
                        ->orWhere('payable', 'like', '%' . $value . '%')
                        ->orWhereHas('address', function ($query) use ($value) {
                            $query->where('full_name', 'like', '%' . $value . '%')
                                ->orWhere('address_line_1', 'like', '%' . $value . '%')
                                ->orWhere('address_line_2', 'like', '%' . $value . '%')
                                ->orWhere('city', 'like', '%' . $value . '%')
                                ->orWhere('post_code', 'like', '%' . $value . '%')
                                ->orWhere('country', 'like', '%' . $value . '%');
                        });
                });
            })
        ]);

        return new DataResourceCollection($this->paginate($ordersQuery));
    }
}
