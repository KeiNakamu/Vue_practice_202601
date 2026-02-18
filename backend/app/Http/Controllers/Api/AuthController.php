<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        Log::info('ユーザー作成開始');
        // ユーザー作成
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        Log::info('ユーザー作成成功', ['user_id' => $user->id]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
    }
}