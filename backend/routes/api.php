<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;

Route::get('/hello', function () {
  return ['message' => 'Hello from API'];
});

// 認証用テストルート
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json([
        'message' => '認証成功',
        'user' => $request->user(),
    ]);
});

// 認証機能
Route::post('/register', [AuthController::class, 'register']);

// Todo画面
Route::get('/todos', [TodoController::class, 'index']);
Route::get('todos/{id}', [TodoController::class, 'show']);
Route::post('/todos', [TodoController::class, 'store']);
Route::put('/todos/{id}', [TodoController::class, 'update']);
Route::delete('/todos/{id}', [TodoController::class, 'destroy']);