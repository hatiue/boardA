<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use App\Http\Requests\Board\CreateRequest;
use App\Services\ThreadService;

class CreateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateRequest $request, ThreadService $threadService)
    {
        // 新規スレッドの情報をDBに保存後、新規スレッドのIDを受け取る
        $threadId = $threadService->createNewThread($request);
        // 立てたスレッドのページへ遷移
        $thread = $threadService->thread($threadId);
        return view('board.thread')->with('thread', $thread);
    }
}
