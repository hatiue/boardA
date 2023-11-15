<?php

namespace App\Http\Controllers\Board\Update;

use App\Http\Controllers\Controller;
use App\Http\Requests\Board\UpdateRequest;
use App\Models\Thread;
use App\Models\Write;

class PutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateRequest $request)
    {
        // 投稿内容の編集※本文のみ
        $write = Write::where('id', $request->id())->firstOrFail();
        $write->content = $request->content();
        $write->save();
        Thread::where('id', $write->thread_id)->update(['updated_at' => $write->updated_at]);
        $title = Thread::where('id', $write->thread_id)->firstOrFail()->title;
        return redirect()
                ->route('update.index', ['writeId' => $write->id])
                ->with(['feedback.success' => "投稿内容を編集しました", 'title' => $title]);
    }
}
