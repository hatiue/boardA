<x-header></x-header>
<body>
    <h2>スレタイ一覧とスレ立てのページ</h2>
    <div>
        メモ1
        <ul>
            <li>スレッドに新規書き込みがあるとスレッドタイトルが上にくる</li>
            <li>書き込みを編集した場合、更新時間も表示される</li>
            <li>削除した時間が更新時間になる</li>
            <li>編集ボタンは会員名で書き込んだもののみ表示（ログイン時）</li>
            <li>書き込み上限時、テキストボックスを非表示に（保存処理も不可）</li>
        </ul>
        メモ2
        <ul>
            <li>エラーメッセージ</li>
            <li>書き込み上限数の設定を1箇所で行いたい</li>
        </ul>
    </div>
    <x-new-thread></x-new-thread>
    <div>
        @foreach($threads as $thread)
            <div>
                <a href="{{ route('thread', ['threadId' => $thread['id']]) }}">
                    <h3>{{ $thread["title"] . "(" . $thread["count"] . ")" }}</h3>
                </a>
                <span>{{ "　最終書き込み：" . $thread["time"] }}</span>
                
            </div>
        @endforeach
    </div>


    <div>
        ビューコンポーネント0922
        <p>作成した</p>
        x-header
        x-footer
        x-new-thread
        x-new-write
        <p>ログインなどに使用するため復活</p>
        x-application-logo
        x-primary-button
        x-input-label
        x-text-input
        x-nav-link
        x-dropdown-link
        x-responsive-nav-link
        <p>消していない</p>
        x-auth-session-status
        x-dropdown
        x-input-error
        x-modal
        <p>消した</p>
        x-secondary-button
        x-danger-button
    </div>
</body>
<x-footer></x-footer>