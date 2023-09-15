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
        $all_threads = Thread::get();
        $array = [];
        foreach ($all_threads as $thread) {
            $array[] = [
                "id" => $thread->id,
                "title" => $thread->title,
                "time" => $thread->updated_at
            ];
        }

        $sortBy = array_column($array, "time"); // ソートの基準
        array_multisort($sortBy, SORT_DESC, $array); // updateの最新順に並べかえてくれる

        return $array;
    }

    // スレッド別ページ用のデータを返す $request->route()でのidの取得について138ページ周辺で見たはずだが元の記載が見つけられない
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
                "content" => $write->content,
                // "user_id" => $write->user_id,
                "name" => $name,
                "created_at" => $write->created_at,
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

                // リレーションを設定する前のコード
                // $latest_threadId = Thread::latest('id')->select('id')->first(); // 最終行(最新)のidを取得
                // $threadId = $latest_threadId["id"];

            // ログインしているならユーザーIDを取得
            $userId = auth()->id() ?: null;
            // 匿名で書き込むならフラグ
            $flg = $request->flg_anonymous() == "on" ? 1 : 0; // checkboxのvalueが設定されていない場合、"on"が送信されるらしい

            $write = new Write;
            $write->content = $request->content();
            $write->ip_address = $request->ip();
            $write->user_id = $userId;
            $write->flg_anonymous = $flg;
                //$write->thread_id = $threadId; // リレーションを設定する前のコード
            $write->thread_id = $thread->id; // 親スレッドへの関連付け
            $threadId = $thread->id;
            $write->save();
            DB::commit();
        } catch (Exception $e) {
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
            // 匿名で書き込むならフラグ
            $flg = $request->flg_anonymous() == "on" ? 1 : 0; // checkboxのvalueが設定されていない場合、"on"が送信されるらしい

            $write = new Write;
            $write->content = $request->content();
            $write->ip_address = $request->ip();
            $write->user_id = $userId;
            $write->flg_anonymous = $flg;
            $write->thread_id = $threadId;
            $write->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }
}