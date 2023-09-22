<x-header></x-header>
<body>
    <h2>スレタイ一覧とスレ立てのページ</h2>
    <div>
        メモ1
        <ul>
            <li>スレッドに新規書き込みがあるとスレッドタイトルが上にくる</li>
            <li>書き込みを編集した場合、更新時間も表示される</li>
        </ul>
        メモ2
        <ul>
            <li>削除フラグを追加してURLへ直接飛んでも編集不可な状態をつくる</li>
            <li>会員登録画面</li>
            <li>エラーメッセージ</li>
            <li>編集まわりをauthで囲う</li>
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