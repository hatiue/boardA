<?php

namespace App\Services;

use App\Models\Thread;
use App\Models\Write;
use Exception;
use Illuminate\Support\Facades\DB;

class ThreadService
{
    // すべてのスレッドタイトルと書き込みを取得、スレッド別に整形してから※未使用
    public function getAllThreadsAndWrites(): array
    {
        $all_threads = Thread::get();
        $all_writes = Write::get();

        $array = [];
        foreach ($all_threads as $thread) {
            // スレッド別の連番
            $num = 1;
            foreach ($all_writes as $write) {
                if($thread->id == $write->thread_id) { // スレッドのIDと一致する書き込み情報を配列に格納する
                    // 名前
                    if ($write->flg_anonymous === 1) {
                        $array[$thread->title][$num]["name"] = "名無し";
                    } else {
                        $array[$thread->title][$num]["name"] = "ユーザー名"; // Todo:実際のユーザー名に書き換える
                    }
                    // 書き込み時間
                    $array[$thread->title][$num]["created_at"] = $write->created_at;
                    // 内容
                    $array[$thread->title][$num]["content"] = $write->content;
                    // imgpath、編集後時間、IPアドレス取得省略
                    // $array[$thread->title][$num]["imgpath"] = $write->imgpath;
                    // $array[$thread->title][$num]["updated_at"] = $write->updated_at;
                    // $array[$thread->title][$num]["ip_address"] = $write->ip_address;
                    $num++;
                }
            }
        }
        return $array;
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

        $titles = [
            "id" => $thread->id,
            "title" => $thread->title
        ];

        // 加工して返す
        $num = 1;
        $array = [];
        foreach ($writes as $write) {
            $name = $write->flg_anonymous ? "名無し" : "会員名"; // Todo:ユーザー名に変更

            $array[] = [
                "num" => $num,
                "write_id" => $write->id,
                "content" => $write->content ?? "削除されました（仮）",
                // "user_id" => $write->user_id,
                "name" => $name,
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
            // 匿名で書き込むならフラグ
            $flg = $request->flg_anonymous() == "on" ? 1 : 0; // checkboxのvalueが設定されていない場合、"on"が送信される

            $write = new Write;
            $write->content = $request->content();
            $write->ip_address = $request->ip();
            $write->user_id = $userId;
            $write->flg_anonymous = $flg;
            $write->thread_id = $thread->id; // 親スレッドへの関連付け
            $threadId = $thread->id;
            $write->save();
            DB::commit();
        } catch (Exception $e) {
            // Todo:メッセージを返す
            DB::rollBack();
        }

        return $threadId;
    }

    // スレッドに書き込む
    public function writeToThread($request, $threadId): void
    {
        try {
            DB::beginTransaction();
            // ログインしているならユーザーIDを取得
            $userId = auth()->id() ?: null;
            // 匿名で書き込むならフラグ(falseでユーザー名※未)
            $flg = $request->flg_anonymous() == "on" ? 1 : 0; // checkboxのvalueが設定されていない場合、"on"が送信される

            $write = new Write;
            $write->content = $request->content();
            $write->ip_address = $request->ip();
            $write->user_id = $userId;
            $write->flg_anonymous = $flg;
            $write->thread_id = $threadId;
            $write->save();
            // 更新時間の反映　save()不要
            Thread::where('id', $write->thread_id)->update(['updated_at' => $write->updated_at]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack(); // Todo:何かメッセージ
        }
    }
}