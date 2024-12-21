<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuthController
 * @package App\Http\Controllers
 *
 * Handles user authentication and registration.
 */
class AuthController extends BaseController
{
    /**
     * Register a new user and return an API token.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam name string required The user's name. Example: John Doe
     * @bodyParam email string required The user's email. Example: john@example.com
     * @bodyParam password string required The user's password. Example: password123
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return $this->sendSuccess(
            ['token' => $user->createToken('API Token')->plainTextToken],
            'User registered successfully!',
            201
        );
    }

    /**
     * Log in a user and return an API token.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam email string required The user's email. Example: john@example.com
     * @bodyParam password string required The user's password. Example: password123
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Login successful.",
     *   "data": {
     *      "token": "sample-token-here"
     *   }
     * }
     * @response 401 {
     *   "message": "Unauthorized"
     * }
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($validated)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();

        return $this->sendSuccess(
            ['token' => $user->createToken('API Token')->plainTextToken],
            'Login successful.'
        );
    }
}
