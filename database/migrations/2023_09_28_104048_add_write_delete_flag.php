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
        // 各書き込みの削除フラグ列を追加、1なら削除済み
        Schema::table('writes', function (Blueprint $table) {
            $table->tinyInteger('flg_deleted')->after('flg_anonymous');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('writes', function (Blueprint $table) {
            $table->dropColumn('flg_deleted');
        });
    }
};
