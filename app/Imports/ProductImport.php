<?php

namespace App\Imports;

use App\Models\Brand;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;


class ProductImport implements ToCollection, WithHeadingRow/* WithBatchInserts, WithChunkReading,*/ /*WithValidation*/
{
    use Importable;

    public function collection(Collection $rows)
    {
       /* $brandNames = $rows->pluck('brand')->unique()->toArray();
        $existingBrands = Brand::whereIn('name', $brandNames)->get();

        if ($existingBrands->count() !== count($brandNames)) {
            $names = [];
            foreach ($brandNames as $brandName) {
                $names[] = ['name' => $brandName];
            }

            Brand::upsert($names, ['name']);
        }

        $existingBrands = Brand::whereIn('name', $brandNames)->get();*/

        $data = [];
       /* foreach ($rows as $row) {
            $data[] = [
                'name' => $row['product_name'],
                'brand_id' => 1,
                'price' => preg_replace('/[^A-Za-z0-9\-]/', '', $row['price']),
                'currency' => 'sdsd'
            ];
        }

        DB::table('products')->insert($data);*/
    }

    /*public function rules(): array
    {
        return [
              'product_name11' => ['required'],
              'brand' => ['required'],
              'price' => ['required']
        ];
    }*/
/*
    public function batchSize(): int
    {
        return 12000;
    }

    public function chunkSize(): int
    {
        return 12000;
    }*/


}
