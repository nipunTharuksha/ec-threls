<?php

namespace App\Http\Controllers;

use App\Http\Resources\DataResource;
use App\Http\Resources\DataResourceCollection;
use App\Models\Product;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends Controller
{
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

    /**
     * @param Product $product
     * @return DataResource
     */
    public function show(Product $product): DataResource
    {
        return new DataResource($product->load('brand:id,name'));
    }
}
