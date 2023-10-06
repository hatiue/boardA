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
        
        $write = Write::where('id', $request->id())->firstOrFail();

        /*
        // 匿名フラグが立っていたら編集不可、IndexControllerで事足りている
        if ($write->flg_anonymous == 1) {
            return redirect()
                ->route('thread', ['threadId' => $write->thread_id])
                ->with("feedback.failure", "匿名で投稿したため、編集することができません(Putコントローラ側)");
        }
        */

        $write->content = $request->content();
        $write->save();
        Thread::where('id', $write->thread_id)->update(['updated_at' => $write->updated_at]);

        return redirect()
                ->route('update.index', ['writeId' => $write->id])
                ->with('feedback.success', "投稿内容を編集しました");
    }
}
