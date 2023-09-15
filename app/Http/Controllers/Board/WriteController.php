<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use App\Http\Requests\Board\WriteRequest;
use App\Services\ThreadService;

class WriteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ThreadService $threadService, WriteRequest $request, $threadId)
    {
        // スレッドに書き込む
        $threadService->writeToThread($request, $threadId);

        $thread = $threadService->thread($threadId);
        return view('board.thread')->with('thread', $thread);
    }
}
