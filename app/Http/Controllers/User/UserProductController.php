<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataResource;
use App\Http\Resources\ProductResourceCollection;
use App\Models\Product;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserProductController extends Controller
{
    /**
     * @return ProductResourceCollection
     */
    public function index(): ProductResourceCollection
    {
        $products = QueryBuilder::for(Product::with('brand:id,name'))
            ->allowedFilters([
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->where(function ($query) use ($value) {
                        $query->where('name', 'like', '%' . $value . '%')
                            ->orWhereHas('brand', function ($query) use ($value) {
                                $query->where('name', 'like', '%' . $value . '%');
                            });
                    });
                })
            ])
            ->paginate(request('paginate') && is_numeric(request('paginate')) ? request('paginate') : 10);

        return new ProductResourceCollection($products);
    }

    /**
     * @param Product $product
     * @return DataResource
     */
    public function show(Product $product): DataResource
    {
        return new DataResource($product);
    }
}
