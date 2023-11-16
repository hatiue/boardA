<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use App\Models\Write;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function __invoke(Request $request)
    {
        $writeId = (int) $request->route('writeId');

        $write = Write::where('id', $writeId)->firstOrFail();
        $threadId = $write->thread_id; // リダイレクト先のスレッド
        
        // 本人のIDでなければそのままリダイレクト
        if ($write->user_id !== $request->user()->id) {
            return redirect()
                ->route('thread', ['threadId' => $threadId])
                ->with("delete.success", "削除する権限がありませんでした");
        }

        $write->flg_deleted = 1;
        // テーブルから本当に削除したい場合はp242参照
        $write->save();
        return redirect()
            ->route('thread', ['threadId' => $threadId])
            ->with("delete.success", "投稿を削除しました");
    }
}
