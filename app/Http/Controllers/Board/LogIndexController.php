<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use App\Services\ThreadService;

class LogIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ThreadService $threadService)
    {
        // 過去ログ一覧ページ
        $threads = $threadService->getAllPastThreads();
        return view('board.threads-log')->with('threads', $threads);
    }
}
