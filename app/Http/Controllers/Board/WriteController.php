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
        // スレッドの書き込み上限を設定,Threadの方にコピペしている
        $upperLimit = 5;
        // スレッドに書き込む
        $threadService->writeToThread($request, $threadId, $upperLimit);
        
        $thread = $threadService->thread($threadId);
        //return view('board.thread')->with('thread', $thread);
        return view('board.thread')->with(["thread" => $thread, "upperLimit" => $upperLimit]);
    }
}
