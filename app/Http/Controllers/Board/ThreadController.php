<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use App\Services\ThreadService;

class ThreadController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ThreadService $threadService, $threadId)
    {
        // スレッドの書き込み上限を取得
        $upperLimit = $threadService->upperLimit();

        $thread = $threadService->thread($threadId);
        return view('board.thread')->with(["thread" => $thread, "upperLimit" => $upperLimit]);
    }
}
