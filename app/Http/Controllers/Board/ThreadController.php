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
        // スレッド個別ページを表示
        $thread = $threadService->thread($threadId);
        return view('board.thread')->with('thread', $thread);
    }
}
