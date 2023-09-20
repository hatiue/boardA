<?php

namespace App\Http\Controllers\Board\Update;

use App\Http\Controllers\Controller;
use App\Models\Write;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $threadId = (int) $request->route('threadId'); // リダイレクト先の指定に必要？
        $writeId = (int) $request->route('writeId'); // スレ別連番では無いのでかなり分かりにくい

        $write = Write::where('id', $writeId)->firstOrFail();
        return view('board.update')->with('write', $write);
    }
}
