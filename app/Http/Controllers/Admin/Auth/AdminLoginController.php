<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\DataResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest:api']);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse|DataResource
     */
    public function login(LoginRequest $request): JsonResponse|DataResource
    {
        $data = $request->validated();

        $user = User::whereEmail($data['email'])->first();

        if (!$user || !($user->hasRole('admin')) || !auth()->attempt($data)) {
            return response()->json(['error_message' => 'Incorrect Details. Please try again'], 422);
        }

        return new DataResource([
            'user' => $user->filteredUserData(),
            'token' => $user->createToken('admin')->accessToken
        ]);
    }
}
