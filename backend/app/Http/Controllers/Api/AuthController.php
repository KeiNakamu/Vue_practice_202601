<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\LoginResponseResource;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return (new LoginResponseResource([
            'token' => $token,
            'user' => $user,
            'message' => 'ユーザー登録成功',
        ]))->response()->setStatusCode(201);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'ログイン情報が正しくありません',
            ], 401);
        }

        $user = Auth::user();

        $token = $user->createToken('api-token')->plainTextToken;

        return new LoginResponseResource([
            'token' => $token,
            'user' => $user,
        ]);
    }
}
