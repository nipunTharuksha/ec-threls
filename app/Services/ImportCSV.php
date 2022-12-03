<?php

namespace App\Services;

use App\Models\Brand;
use DB;

class ImportCSV
{
    private array $lines;

    public function __construct(array $lines)
    {
        $this->lines = $lines;
    }

    /**
     * @return bool
     */
    public function import(): bool
    {
        $brandNames = collect($this->lines)->pluck('brand')->unique()->values()->toArray();

        $this->createBrands($brandNames);
        $data = $this->prepareData($brandNames);
        $chunkedData = collect($data)->chunk(count($data) / 10);

        $chunkedData->each(function ($products) {
            DB::table('products')->insert($products->toArray());
        });

        return true;
    }

    /**
     * @param array $names
     * @return void
     */
    protected function createBrands(array $names): void
    {
        $data = [];
        foreach ($names as $name) {
            $data[] = ['name' => $name];
        }

        Brand::upsert($data, ['name']);
    }

    /**
     * @param array $brandNames
     * @return array
     */
    protected function prepareData(array $brandNames): array
    {
        $brands = Brand::whereIn('name', $brandNames)->get();
        $finalData = [];

        $brandWiseProducts = collect($this->lines)->groupBy('brand');
        $now = now();

        foreach ($brandWiseProducts as $products) {
            $brandId = $brands->where('name', $products->first()['brand'])->first()->id;

            foreach ($products as $product) {
                $product['brand_id'] = $brandId;
                unset($product['brand']);
                $product['created_at'] = $now;
                $product['price'] = (preg_replace('/[^A-Za-z0-9\-]/', '', $product['price'])) * 100;
                $product['currency'] = 'EUR';
                $finalData[] = $product;
            }
        }

        return collect($finalData)->sortBy('name')->values()->all();
    }

}
