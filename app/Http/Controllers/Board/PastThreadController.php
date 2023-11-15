<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use App\Services\ThreadService;

class PastThreadController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ThreadService $threadService, $threadId)
    {
        // 過去ログ送りになったスレッドの個別ページ
        $thread = $threadService->getThreadWithImages($threadId);
        // 現行スレッドにアクセスした場合、トップへ　ThreadControllerと対
        if ($thread[0]["flg_log"] == 0) {
            return redirect()->route('log')->with('itsCurrent', "さっき表示しようとしたのは現行のスレッドです");
        }
        return view('board.past-thread')->with("thread", $thread);
    }
}
