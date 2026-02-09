<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Todo;
use Exception;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Log;
use Throwable;

class TodoController extends Controller
{
    /**
     * 初期表示
     */
    public function index()
    {
      try{
        Log::info('Todo画面　表示処理開始');
        $todos = Todo::all();

        // Log::debug('取得データ：', $todos->toArray());
        return response()->json([
          'status' => 'success',
          'todos' => $todos,
          ]);
      }catch (\Throwable $e){
        Log::error('Todo画面　表示処理に失敗しました');
        Log::error($e);

        return response()->json([
          'status' => 'failed',
          'message' => 'データの取得に失敗しました',
          'error' => $e->getMessage(),
        ], 500);
      }
    }

    /**
     * タスクの新規作成
     */
    public function store(Request $request)
    {
      try{
        Log::info('Todo画面　タスクの登録処理開始');
        // Log::debug('request', $request->all());
        $validated = $request->validate([
          'content' => 'required|string|max:255',
          'limit_date' => 'required|date',
          'state' => 'required|string',
        ]);

        $todo = Todo::create([
          ...$validated,
          'created_process' => 'todo_create',
        ]);

        Log::info('Todo画面　タスクの登録処理終了');
        return response()->json([
          'status' => 'success',
          'todo' => $todo,
        ], 201);
      }catch (\Throwable $e){
        Log::error('Todo画面　登録に失敗しました');
        Log::error($e);

        return response()->json([
          'status' => 'failed',
          'message' => '登録に失敗しました',
          'error' => $e->getMessage(),
        ], 500);
      }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * タスクの更新
     */
    public function update(Request $request, string $id)
    {
      try{
        Log::info('Todo画面　更新処理開始 id: ' . $id);
        // Log::debug('request', $request->all());

        $validated = $request->validate([
          'content' => 'required|string|max:255',
          'limit_date' => 'required|date',
          'state' => 'required|string',
        ]);

        $todo = Todo::findOrFail($id);

        $todo->update([
          ...$validated,
          'updated_process' => 'todo_update',
        ]);

        return response()->json([
          'status' => 'success',
          'message' => '更新されました',
        ]);
      }catch (\Throwable $e){
        Log::error('Todo画面　更新処理に失敗しました');
        Log::error($e);

        return response()->json([
          'status' => 'failed',
          'message' => '更新に失敗しました',
          'error' => $e->getMessage(),
        ], 500);
      }
    }

    /**
     * タスクの削除
     */
    public function destroy(string $id)
    {
      try{
        Log::info('Todo画面　削除処理を開始 対象 id: ' . $id);
        $todo = Todo::findOrFail($id);

        $todo->delete();

        Log::info('Todo画面　削除処理を終了');

        return response()->json([
          'status' => 'success',
          'message' => '削除しました',
        ], 200);
      }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

        Log::warning('Todo画面　削除対象が見つかりません', ['id' => $id]);

        return response()->json([
            'status' => 'failed',
            'message' => '削除対象が存在しません',
        ], 404);

      }catch (\Throwable $e){
        Log::error('Todo画面　削除処理に失敗しました');
        Log::error($e);

        return response()->json([
          'status' => 'failed',
          'message' => '削除処理に失敗しました',
        ], 500);
      }
    }
}
