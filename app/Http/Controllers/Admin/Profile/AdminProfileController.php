<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataResource;
use Illuminate\Http\JsonResponse;

class AdminProfileController extends Controller
{
    /**
     * @return DataResource
     */
    public function profile(): DataResource
    {
        return new DataResource(auth()->user()->filteredUserData());
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json(['success' => true]);
    }
}
