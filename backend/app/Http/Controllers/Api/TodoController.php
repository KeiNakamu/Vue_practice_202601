<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Todo;
use Exception;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Log;
use Throwable;
use App\Const\Message;
use App\Http\Requests\TodoStoreRequest;
use App\Http\Requests\TodoUpdateRequest;

class TodoController extends Controller
{
    /**
     * 初期表示
     */
    public function index()
    {
      try{
        Log::info('Todo画面　表示処理開始');
        // throw new Exception();
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
          'message' => Message::ERR_00_002,
          'error' => $e->getMessage(),
        ], 500);
      }
    }

    /**
     * タスクの新規作成
     */
    public function store(TodoStoreRequest $request)
    {
      try{
        Log::info('Todo画面　タスクの登録処理開始');
        $validated = $request->validated();

        $todo = Todo::create([
          ...$validated,
          'created_process' => 'todo_create',
        ]);

        Log::info('Todo画面　タスクの登録処理終了');
        return response()->json([
          'status' => 'success',
          'message' => Message::INF_01_001,
          'todo' => $todo,
        ], 201);
      }catch (\Throwable $e){
        Log::error('Todo画面　登録に失敗しました');
        Log::error($e);

        return response()->json([
          'status' => 'failed',
          'message' => Message::ERR_01_001,
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
    public function update(TodoUpdateRequest $request, string $id)
    {
      try{
        Log::info('Todo画面　更新処理開始 id: ' . $id);
        // Log::debug('request', $request->all());

        $validated = $request->validated();

        $todo = Todo::findOrFail($id);

        $todo->update([
          ...$validated,
          'updated_process' => 'todo_update',
        ]);

        return response()->json([
          'status' => 'success',
          'message' => Message::INF_01_002,
        ]);
      }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

        Log::warning('Todo画面　更新対象が見つかりません', ['id' => $id]);

        return response()->json([
            'status' => 'failed',
            'message' => Message::WAR_01_001,
        ], 404);

      }catch (\Throwable $e){
        Log::error('Todo画面　更新処理に失敗しました');
        Log::error($e);

        return response()->json([
          'status' => 'failed',
          'message' => Message::ERR_01_002,
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
          'message' => Message::INF_01_003,
        ], 200);
      }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

        Log::warning('Todo画面　削除対象が見つかりません', ['id' => $id]);

        return response()->json([
            'status' => 'failed',
            'message' => Message::WAR_01_002,
        ], 404);

      }catch (\Throwable $e){
        Log::error('Todo画面　削除処理に失敗しました');
        Log::error($e);

        return response()->json([
          'status' => 'failed',
          'message' => Message::ERR_01_003,
        ], 500);
      }
    }
}
