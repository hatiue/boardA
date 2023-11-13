<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use App\Services\ThreadService;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ThreadService $threadService)
    {
        // ホーム、スレッド一覧
        // $threadService = new ThreadService; // 引数に入れるとnewしなくてよくなる
        $threads = $threadService->getAllCurrentThreads();
        return view('board.index')->with('threads', $threads);
    }
}
