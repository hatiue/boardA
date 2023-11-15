<x-header></x-header>
    <div class="flex-grow container mx-auto">
        <div class="my-2">
            <p class="font-medium">メモ</p>
            <ul class="list-disc border border-gray-200 px-6 py-1">
                <li>スレッドに新規書き込みがあるとスレッドタイトルが上にくる</li>
                <li>書き込みを編集・削除した場合、更新時間も表示</li>
                <li>編集ボタンは会員名で書き込んだもののみ表示（ログイン時）</li>
                <li>書き込み上限時、テキストボックスを非表示に（保存処理も不可）</li>
                <li>画像が保存されていた場合表示（4枚まで）</li>
                <li>「>>1」の形で書き込みがあればページ内ジャンプ</li>
                <li>過去ログ送りになると会員でも編集削除不可に</li>
            </ul>
        </div>

        @if (session("itsPast"))
            <p class="text-red-400">{{ session("itsPast") }}</p>
        @endif

        <h2 class="text-white text-xl mt-2">スレッド一覧</h2>
        <div>
            @foreach($threads as $thread)
                <div class="inline-block">
                    <span class="text-lg underline underline-offset-4">
                        <a href="{{ route('thread', ['threadId' => $thread['id']]) }}">
                            {{ $thread["title"] . "(" . $thread["count"] . ")" }}
                        </a>
                    </span>
                    <span class="text-sm">{{ "最終：" . $thread["time"] }}</span>
                </div>
            @endforeach
        </div>
        <x-button-log></x-button-log>
        <x-new-thread></x-new-thread>
    </div>
    <x-footer></x-footer>
</body>
</html>