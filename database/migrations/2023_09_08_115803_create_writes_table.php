<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('writes', function (Blueprint $table) {
            $table->id(); // 全書き込みの通し番号
            $table->string('content'); // 書き込み
            $table->string('imgpath')->nullable(); // 画像パスの予定だったが交差テーブルの作成で不要になった
            $table->string('ip_address'); // IPアドレス
            $table->foreignId('user_id')->nullable()->constrained(); // ユーザーID、強制ではないためnullable（constrainedの後に書くと無効の模様
            $table->unsignedTinyInteger('flg_anonymous'); // 匿名で書き込むかどうか（ログインユーザーはユーザー名を使用するかどうか選択できる）
            $table->foreignId('thread_id')->constrained(); // スレッドID
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('writes');
    }
};
