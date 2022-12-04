
# E-Commerce - API

## Requirements
* Import products via a CSV
* Authentication for user with reigstration,login and logout
* End users should be able to add products in to cart and they should be able to place an order


## Demo

https://www.loom.com/share/3bb11fedbe1d46bc8ccf937b4b948f77


## Run Locally

Clone the project

```bash
  git@github.com:nipunTharuksha/ec-threls.git
```

Go to the project directory

```bash
  cd ec-threls
```

Install dependencies

```bash
  composer install
```

Create .env and update DB credentials

Initialize the project (Below command will execute all required commands as a sequence)

```bash
php artisan project:init
```

Start the server

```bash
  php artisan serve
```


## API Reference

https://documenter.getpostman.com/view/19165023/2s8YzMXQYe#intro


## Packages used

* [Laravel-model-states](https://spatie.be/docs/laravel-model-states/v2/01-introduction) - Used for order states ,payment states . 
```
public static function config():StateConfig {
        return parent::config()
            ->default(PaymentPendingState::class)
            ->allowTransition(PaymentPendingState::class, PaymentDeclinedState::class)
            ->allowTransition(PaymentPendingState::class, PaymentAcceptedState::class);
}
```

* [Laravel-query-builder](https://spatie.be/docs/laravel-query-builder/v5/introduction) - Used for query filters



```
/**
     * @return DataResourceCollection
     */
    public function index(): DataResourceCollection
    {
        $productsQuery = QueryBuilder::for(Product::with('brand:id,name'))
            ->select(['id', 'name', 'price', 'brand_id', 'currency', 'created_at'])
            ->allowedFilters([
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->where(function ($query) use ($value) {
                        $query->where('name', 'like', '%' . $value . '%')
                            ->orWhereHas('brand', function ($query) use ($value) {
                                $query->where('name', 'like', '%' . $value . '%');
                            });
                    });
                })
            ]);

        return new DataResourceCollection($this->paginate($productsQuery));
    }
```

* [Laravel-permission](https://spatie.be/docs/laravel-permission/v5/introduction) - Used for user roles



```
Route::middleware(['auth:api', 'role:user'])
```

```
$user = User::create($data);
$user->assignRole('user');
```

* [Laravel-enum](https://github.com/BenSampo/laravel-enum) - Used for payment types



```
/**
 * @method static static COD()
 * @method static static CP()
 */
final class OrderPaymentType extends Enum
{
    const COD = 'COD'; // Cash on delivery
    const CP = 'CP'; // Card payment
}
```

* [Laravel-API-response-helpers](https://github.com/f9webltd/laravel-api-response-helpers) - Used for responses



```
 return $this->respondCreated();
```

* [Laravel-cart-manager](https://github.com/freshbitsweb/laravel-cart-manager) - Used for cart related functionalities



```
     /**
     * @return DataResource
     */
    public function cartData(): DataResource
    {
        cart()->setUser(auth()->id());
        return new DataResource([cart()->totals() + ['items' => cart()->items(true)]]);
    }
```

```
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
```

```
    /**
     * @return JsonResponse
     */
    public function deleteCart(): JsonResponse
    {
        cart()->setUser(auth()->id());
        cart()->clear();
        return $this->respondNoContent();
    }
```

