<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use App\Models\Write;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // 削除→内容が書き換わる　その後編集が不可能になってほしい
        $writeId = (int) $request->route('writeId');
        $write = Write::where('id', $writeId)->firstOrFail();
        $threadId = $write->thread_id; // リダイレクト先のスレッド
        // $write->delete();
            // Write::destroy($writeId); // 削除処理はこの1行でもできる
        $write->content = "この投稿は削除されました。"; // 内容を上書き
        $write->save();

        return redirect()
            ->route('thread', ['threadId' => $threadId])
            ->with("delete.success", "投稿を削除しました");
    }
}
