<?php

namespace App\Http\Controllers\Board\Update;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use App\Models\Write;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $writeId = (int) $request->route('writeId');

        $write = Write::where('id', $writeId)->firstOrFail();
        $title = Thread::where('id', $write->thread_id)->firstOrFail()->title;
        // 匿名フラグが立っていたら編集不可
        if ($write->flg_anonymous == 1) {
            return redirect()
                ->route('thread', ['threadId' => $write->thread_id])
                ->with("feedback.failure", "匿名で投稿したため、編集することができません");
        }

        return view('board.update')->with(['write' => $write, 'title' => $title]);
    }
}
