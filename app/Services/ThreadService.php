<?php

namespace App\Services;

use App\Models\Thread;
use App\Models\Write;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

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

        /* 最終更新が近い順に書き込みデータを取得する UPDATEの使用で不要に
        $all_writes_desc = $all_writes->sortByDesc('updated_at'); // $all_writes->groupBy('thread_id')->sortByDesc('updated_at');
        $group_writes = $all_writes_desc->groupBy('thread_id'); // 使えるがちょっと不安
        foreach ($group_writes as $key => $group_write) {
            $updateds[$key] = $group_write[0]->updated_at;
        }
        */

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

    // スレッド別ページ用のデータを返す 一部90ページ参照
    public function thread($threadId): array
    {
        // コントローラの引数にルートのパラメータ(threadId)を入れて使えるようにしている
        $thread = Thread::where('id', $threadId)->first();
        $writes = Write::where('thread_id', $threadId)->get();
        $users = User::all(); // 配列か何かにして、ループ内で検索させてみる
        
        $titles = [
            "id" => $thread->id,
            "title" => $thread->title
        ];

        // 加工して返す
        $num = 1;
        $array = [];
        foreach ($writes as $write) {
            if ($write->flg_deleted === 0) {
                //$name = $write->flg_anonymous ? "名無し" : "会員名"; // Todo:ユーザー名に変更
                if ($write->flg_anonymous === 1) {
                    $name = "名無し";
                } else {
                    $name_search = $users->where("id", $write->user_id)->first();
                    $name = $name_search->name ?? "名前を表示したいが、ユーザーIDの保存ができていないようだ…";
                    //$name = $write->user->name ?? "名前を表示したいが、ユーザーIDの保存ができていないようだ…"; // null

                }
                $content = $write->content;
            } else {
                $name = "わァ...... ......ぁ....";
                $content = "消しちゃった!!!";
            }

            $array[] = [
                "num" => $num . " : ",
                "write_id" => $write->id,
                "content" => $content,
                "user_id" => $write->user_id,
                "name" => $name,
                "flg_anonymous" => $write->flg_anonymous,
                "flg_deleted" => $write->flg_deleted,
                "created_at" => $write->created_at,
                "updated_at" => $write->updated_at,
                // "imgpath" => $write->imgpath,
                // "ip_address" => $write->ip_address,
            ];
            $num++;
         }
         
         $array_thread = [$titles, $array];
         return $array_thread;
    }

    // スレ立て、新規スレッドと1番目の書き込みを保存し、作成したスレッドのIDを返す
    public function createNewThread($request): int
    {
        // https://readouble.com/laravel/10.x/ja/database.html
        /*
         DB::transaction(function(CreateRequest $request) { // コントローラにある間はこちらで動いたのだが…
            // 保存処理
        });
        */
        try {
            DB::beginTransaction();
            $thread = new Thread;
            $thread->title = $request->title();
            $thread->flg_not_writable = 0;
            $thread->save();

            // ログインしているならユーザーIDを取得
            $userId = auth()->id() ?: null;

            // 匿名で書き込むか　別メソッドに分離したい
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
            
            // 匿名で書き込むか　別メソッドに分離したい
            if ($userId == null) {
                // 非ログイン時、匿名になる　DevツールでHTMLを直に編集してinputタグを追加できたためこちらで付け直す
                $flg = 1;

                /* 動作確認用、非ログイン時に匿名チェックが入力通りになる処理　不要になり次第削除
                if ($request->flg_anonymous() === "on") {
                    $flg = 1;
                } else { 
                    $flg = 0;
                }
                */
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

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            echo $e;
            die;
        }
    }
}