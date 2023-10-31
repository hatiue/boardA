<?php

namespace App\Http\Controllers\Board\Update;

use App\Http\Controllers\Controller;
use App\Http\Requests\Board\UpdateImageRequest;
use App\Models\Thread;
use App\Models\Write;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PutImageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateImageRequest $request)
    {
        // 画像の差し替え、編集中
        $write = Write::with('images')->where('id', $request->id())->firstOrFail();
        $message = "さしかえはできません";
        //dd($request);
        if ($request->hasFile('newImage')) {
            $newImage = $request->file('newImage');

            Storage::putFile('public/images', $newImage);
            $imageModel = new Image();
            $imageModel->name = $newImage->hashName();
            $imageModel->save();
            $write->images()->attach($imageModel->id);

            $write->save();
            Thread::where('id', $write->thread_id)->update(['updated_at' => $write->updated_at]);
            $message = "画像を変更しました";
        }
        return redirect()
                ->route('update.index', ['writeId' => $write->id])
                ->with('feedback.success', $message);
    }
}
