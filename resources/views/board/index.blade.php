<x-header></x-header>
    <div class="min-h-screen flex flex-col">
        <div class="container mx-auto">
            <div>
                <h2 class="text-xl">スレタイ一覧とスレ立てのページ</h2>
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
                        <li>会員のみ画像複数投稿(仮)と削除を可能にする</li>
                        <li>後でclassのborderは基本的に外す</li>
                    </ul>
                </div>
            </div>
            <x-new-thread></x-new-thread>
            <div>
                @foreach($threads as $thread)
                    <div>
                        <p class="text-lg underline underline-offset-4">
                            <a href="{{ route('thread', ['threadId' => $thread['id']]) }}">
                                {{ $thread["title"] . "(" . $thread["count"] . ")" }}
                            </a>
                        </p>
                        <span class="text-sm">{{ "最終書き込み：" . $thread["time"] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <x-footer></x-footer>
</body>