<?php

namespace App\Const;

class Message
{
  /**
   * メッセージ：INF
   * 警告：     WAR
   * エラー：   ERR
   * 
   * 画面ID
   * 共通：00
   * Todo画面：01
   */
  // 共通
  public const WAR_00_001 = '権限がありません';
  public const ERR_00_001 = '予期しないエラーが発生しました';
  public const ERR_00_002 = 'データの取得に失敗しました';

  // Todo 関連
  public const INF_01_001 = '登録しました';
  public const INF_01_002 = '更新しました';
  public const INF_01_003 = '削除しました';
  public const WAR_01_001 = '更新対象が存在しません';
  public const WAR_01_002 = '削除対象が存在しません';
  public const WAR_01_003 = 'タスク・期限を両方入力してください';
  public const WAR_01_004 = '他に編集中のタスクがあります';
  public const ERR_01_001 = '登録に失敗しました';
  public const ERR_01_002 = '更新に失敗しました';
  public const ERR_01_003 = '削除に失敗しました';

}