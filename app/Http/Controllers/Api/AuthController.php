<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Authenticate the user using sanctum token
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login (Request $request): JsonResponse
    {
        // Validate the request
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'device_name' => ['required']
        ]);

        // Prepare request data
        $email = data_get($validated, 'email');
        $password = data_get($validated, 'password');
        $deviceName = data_get($validated, 'device_name');

        /** @var User $user */
        $user = User::query()
            ->where('email', $email)
            ->first();

        // Attempt login
        if (! $user || ! Hash::check($password, $user->password)) {
            return $this->validationError([
                'email' => __('The provided credentials are incorrect.')
            ]);
        }

        // Revoke past token
        $user->tokens()->delete();

        return $this->success([
            '_token' => $user->createToken($deviceName)->plainTextToken
        ]);
    }
}
