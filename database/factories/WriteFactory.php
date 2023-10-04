<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use App\Models\Thread;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Write>
 */
class WriteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $latest_threadId = Thread::latest('id')->select('id')->first(); // tinkerで指定方法を確認した
        $write_threadId = $latest_threadId["id"];// 書き込むスレッドIDを文字列に変換

        return [
            'content' => $this->faker->realText(50),
            'imgpath' => null,
            'ip_address' => '127.0.0.1', // 仮
            'user_id' => null, // 非ログイン状態
            'flg_anonymous' => 1, // 匿名で書き込む（0はログインかつ会員として書き込む）
            'flg_deleted' => 0, // 削除されていない状態
            'thread_id' => $write_threadId, // 最新のスレッドに書き込む（idが最大、Factoryで同時生成するもの）
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
