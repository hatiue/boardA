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
        $writeId = (int) $request->route('writeId');
        $write = Write::where('id', $writeId)->firstOrFail();
        $threadId = $write->thread_id; // リダイレクト先のスレッド
        $write->flg_deleted = 1;
        $write->save();

        return redirect()
            ->route('thread', ['threadId' => $threadId])
            ->with("delete.success", "投稿を削除しました");
    }
}
