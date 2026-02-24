<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\MeController;
use Illuminate\Http\Request;

Route::get('/hello', function () {
  return ['message' => 'Hello from API'];
});

// 認証機能
Route::middleware('auth:sanctum')->get('/me', MeController::class);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Todo画面
Route::get('/todos', [TodoController::class, 'index']);
Route::get('todos/{id}', [TodoController::class, 'show']);
Route::post('/todos', [TodoController::class, 'store']);
Route::put('/todos/{id}', [TodoController::class, 'update']);
Route::delete('/todos/{id}', [TodoController::class, 'destroy']);