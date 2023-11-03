<x-header></x-header>
    <div class="min-h-screen flex flex-col">
        <div class="container mx-auto">
            <div>
                
                <div class="my-2">
                    <p class="font-medium">メモ1</p>
                    <ul class="list-disc border border-gray-200 px-6 py-1">
                        <li>スレッドに新規書き込みがあるとスレッドタイトルが上にくる</li>
                        <li>書き込みを編集した場合、更新時間も表示される</li>
                        <li>削除した時間が更新時間になる</li>
                        <li>編集ボタンは会員名で書き込んだもののみ表示（ログイン時）</li>
                        <li>書き込み上限時、テキストボックスを非表示に（保存処理も不可）</li>
                        <li>画像が保存されていた場合表示（4枚まで）</li>
                    </ul>
                    <p class="font-medium">メモ2</p>
                    <ul class="list-disc border border-gray-200 px-6 py-1">
                        <li>エラーメッセージ</li>
                        <li>後でclassのborderは基本的に外す</li>
                    </ul>
                </div>
            </div>
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
            <x-new-thread></x-new-thread>
        </div>
    </div>

    <x-footer></x-footer>
</body>