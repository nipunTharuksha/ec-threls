<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Cart\AddToCartRequest;
use App\Http\Requests\User\Cart\UpdateCartItemRequest;
use App\Http\Resources\DataResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class UserCartController extends Controller
{

    /**
     * @return DataResource
     */
    public function cartData(): DataResource
    {
        cart()->setUser(auth()->id());
        return new DataResource([cart()->totals() + ['items' => cart()->items(true)]]);
    }

    /**
     * @param $cartItemId
     * @return JsonResponse
     * @throws ValidationException
     */
    public function removeFromCart($cartItemId): JsonResponse
    {
        cart()->setUser(auth()->id());

        $this->validateItem($cartItemId);

        cart()->removeAt($this->getItemIndex($cartItemId));

        return $this->respondNoContent();
    }

    /**
     * @param $cartItemId
     * @return void
     * @throws ValidationException
     */
    protected function validateItem($cartItemId): void
    {
        if (!(collect(cart()->items())->contains('id', $cartItemId))) {
            throw ValidationException::withMessages(['This item does not exists in your cart.']);
        }
    }

    protected function getItemIndex($cartItemId)
    {
        return collect(cart()->items())->search(function ($item) use ($cartItemId) {
            return $item['id'] === (int)$cartItemId;
        });
    }

    /**
     * @param AddToCartRequest $request
     * @return JsonResponse
     */
    public function addToCart(AddToCartRequest $request): JsonResponse
    {
        $data = $request->validated();
        cart()->setUser(auth()->id());
        $cartItem = Product::addToCart($data['product_id'], $data['quantity']);

        return $this->respondCreated();
    }

    /**
     * @param $cartItemId
     * @param UpdateCartItemRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function updateItemQuantity($cartItemId, UpdateCartItemRequest $request): JsonResponse
    {
        cart()->setUser(auth()->id());

        $this->validateItem($cartItemId);

        cart()->setQuantityAt($this->getItemIndex($cartItemId), request('quantity'));

        return $this->respondNoContent();
    }

    /**
     * @return JsonResponse
     */
    public function deleteCart(): JsonResponse
    {
        cart()->setUser(auth()->id());
        cart()->clear();
        return $this->respondNoContent();
    }
}
