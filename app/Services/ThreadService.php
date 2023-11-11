<?php

namespace App\Services;

use App\Models\Thread;
use App\Models\Write;
use App\Models\User;
use App\Models\Image;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ThreadService
{
    // スレッドの書き込み上限を設定する　適宜都合の良い数値に変更
    public function upperLimit(): int
    {
        // Controller(Create,Thread,Write)で使用
        return 10;
    }

    // スレッドタイトル一覧
    public function getAllThreads(): array
    {
        // スレッドタイトル一覧を取得
        $all_threads = Thread::orderBy('updated_at', 'DESC')->get(); // Write側からupdated_atを更新：thread()に実装済
        
        // レス数（タイトル横に表示させる）
        $all_writes = Write::get();
        $count_writes = $all_writes->countBy('thread_id');

        $array = [];
        foreach ($all_threads as $thread) {
            $array[] = [
                "id" => $thread->id,
                "title" => $thread->title,
                "time" => $thread->updated_at ?? "なし",
                "count" => $count_writes[$thread->id] ?? 0 // 書き込みがなければ0、今はエラーなどで存在しているため代入
            ];
        }

        return $array;
    }

    // スレ立て、新規スレッドと1番目の書き込みを保存し、作成したスレッドのIDを返す
    public function createNewThread($request): int
    {
        // https://readouble.com/laravel/10.x/ja/database.html
        /*
         DB::transaction(function(CreateRequest $request) { // コントローラにある間はこちらで動いたのだが…
            // 保存処理
            → DB::transaction(function() use (CreateRequest $request) { // p237試していないが、関数外で定義した変数を利用する際にはuse()が必要とのこと
        */
        try {
            DB::beginTransaction();
            $thread = new Thread;
            $thread->title = $request->title();
            $thread->flg_not_writable = 0;
            $thread->save();

            // ログインしているならユーザーIDを取得
            $userId = auth()->id() ?: null;

            // 匿名で書き込むかどうか
            if ($userId == null) {
                // 非ログイン時、匿名になる
                $flg = 1;
            } elseif ($userId && $request->flg_anonymous() == "on") {
                // ログイン時、匿名フラグを立てていれば、匿名になる
                $flg = 1;
            } elseif ($userId == null && $request->flg_anonymous() == null) {
                // ユーザーIDの情報が無い場合、匿名フラグを外していても無効にする※作成現在はこれがある
                throw new Exception('エラー：ログインしていないため、匿名でしか投稿できません。');
                // $flg = 1;
            } else {
                $flg = 0; // ログイン時、匿名フラグを外していれば、会員名を使用する
            }

            $write = new Write;
            $write->content = $request->content();
            $write->ip_address = $request->ip();
            $write->user_id = $userId;
            $write->flg_anonymous = $flg;
            $write->flg_deleted = 0;
            $write->thread_id = $thread->id; // 親スレッドへの関連付け
            $threadId = $thread->id;
            $write->save();

            if($request->images) {
                foreach ($request->images as $image) {
                    Storage::putFile('public/images', $image);
                    $imageModel = new Image();
                    $imageModel->name = $image->hashName();
                    $imageModel->save();
                    $write->images()->attach($imageModel->id);
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            echo $e;
            die;
        }

        return $threadId;
    }

    // スレッドに書き込む
    public function writeToThread($request, $threadId, $upperLimit): void
    {
        // スレッドの書き込み数上限に達していたら書き込めないようにする
        $total = Write::where('thread_id', $threadId)->count();
        if ($total >= $upperLimit) {
            return;
        }
        unset($total); // この後使わないので

        try {
            DB::beginTransaction();
            // ログインしているならユーザーIDを取得
            $userId = auth()->id() ?: null;
            if ($userId) { // 存在しないidならModelNotFoundExceptionを投げる、ただ検証できていない
                User::where('id', $userId)->firstOrFail();
            }
            
            // 匿名で書き込むかどうか
            if ($userId == null) {
                // 非ログイン時、匿名になる
                $flg = 1;

            } elseif ($userId && $request->flg_anonymous() == "on") {
                // ログイン時、匿名フラグを立てていれば、匿名になる
                $flg = 1;
            } elseif ($userId == null && $request->flg_anonymous() == null) {
                // ユーザーIDの情報が無い場合、匿名フラグを外していても無効にする※作成現在はこれがある
                throw new Exception('エラー：ログインしていないため、匿名でしか投稿できません。');
                // $flg = 1;
            } else {
                $flg = 0; // ログイン時、匿名フラグを外していれば、会員名を使用する
            }

            $write = new Write;
            $write->content = $request->content();
            $write->ip_address = $request->ip();
            $write->user_id = $userId;
            $write->flg_anonymous = $flg;
            $write->flg_deleted = 0;
            $write->thread_id = $threadId;
            $write->save();
            // 更新時間の反映　save()不要
            Thread::where('id', $write->thread_id)->update(['updated_at' => $write->updated_at]);

            if($request->images) {
                foreach ($request->images as $image) {
                    Storage::putFile('public/images', $image);
                    $imageModel = new Image();
                    $imageModel->name = $image->hashName();
                    $imageModel->save();
                    $write->images()->attach($imageModel->id);
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            echo $e;
            die;
        }
    }

    // 画像を含めたスレッド個別ページのデータを取得する
    public function getThreadWithImages($threadId): array
    {
        // コントローラの引数にルートのパラメータ(threadId)を入れて使えるようにしている
        $thread = Thread::where('id', $threadId)->first();
        $writes = Write::with('images')->where('thread_id', $threadId)->get();
        $users = User::all();

        $titles = [
            "id" => $thread->id,
            "title" => $thread->title
        ];

        // 加工して返す
        $num = 1;
        $array = [];
        foreach ($writes as $write) {
            if ($write->flg_deleted === 0) {
                // 削除していない場合
                if ($write->flg_anonymous === 1) {
                    $name = "名無し";
                } else {
                    $name_search = $users->where("id", $write->user_id)->first();
                    $name = $name_search->name ?? "名前を表示したいが、ユーザーIDの保存ができていないようだ…";

                }
                // 本文にアンカーがある場合リンクに置き換える
                if (preg_match("/>>(\d+)/", $write->content) > 0) {
                    // アンカーで区切る
                    $anchors = preg_split("/>>(\d+)/", $write->content, 0, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
                    // 残った数字がアンカーなのかを判別したいが今は気にしない
                    $content = $anchors;
                } else {
                    // アンカーがなければそのまま
                    $content = $write->content;
                }
                $images = $write->images;
            } else {
                // 削除済みの場合の表示
                $name = "わァ...... ......ぁ....";
                $content = "消しちゃった!!!";
                $images = []; // $images = ""だとエラー
            }

            $array[] = [
                "num" => $num,
                "write_id" => $write->id,
                "content" => $content,
                "user_id" => $write->user_id,
                "name" => $name,
                "flg_anonymous" => $write->flg_anonymous,
                "flg_deleted" => $write->flg_deleted,
                "created_at" => $write->created_at,
                "updated_at" => $write->updated_at,
                "images" => $images,
                // "ip_address" => $write->ip_address,
            ];
            $num++;
         }
         $array_thread = [$titles, $array];
         return $array_thread;
    }

}