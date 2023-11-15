<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use App\Services\ThreadService;
use App\Models\Thread;

class ThreadController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ThreadService $threadService, $threadId)
    {
        // スレッドの書き込み上限を取得
        $upperLimit = $threadService->upperLimit();
        $thread = $threadService->getThreadWithImages($threadId);

        // 過去ログ送りになったスレッドにアクセスした場合、トップへ　PastThreadControllerと対
        if ($thread[0]["flg_log"] == 1) {
            return redirect()->route('home')->with('itsPast', "さっき表示しようとしたのは過去ログのスレッドです");
        }

        return view('board.thread')->with(["thread" => $thread, "upperLimit" => $upperLimit]);
    }
}
