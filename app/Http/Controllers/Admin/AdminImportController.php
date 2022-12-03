<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ImportRequest;
use App\Services\ImportCSV;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class AdminImportController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function importProducts(ImportRequest $request): JsonResponse
    {
        ini_set('max_execution_time', 60);

        $csvData = file_get_contents($request->file('csv'));
        $lines = explode(PHP_EOL, $csvData);

        $products = [];

        //Doing extra validations here without doing them at service level
        foreach ($lines as $index => $line) {
            if ($index === 0) {
                //Ignore header
                continue;
            }
            if (count(str_getcsv($line)) < 3) {
                throw ValidationException::withMessages(['Please check your CSV file again']);
            }
            $values = str_getcsv($line);
            $products[] = ['name' => $values[0], 'brand' => $values[1], 'price' => $values[2]];
        }

        $success = (new ImportCSV($products))->import();

        return response()->json(['success' => $success]);
    }

}
