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
        // スレッドの書き込み上限
        $upperLimit = $threadService->upperLimit();
        // スレッドに書き込む
        $threadService->writeToThread($request, $threadId, $upperLimit);
        
        $thread = $threadService->getThreadWithImages($threadId);
        return view('board.thread')->with(["thread" => $thread, "upperLimit" => $upperLimit]);
    }
}
