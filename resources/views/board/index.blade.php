<x-header></x-header>
<body>
    <h2>スレタイ一覧とスレ立てのページ</h2>
    <x-new-thread></x-new-thread>
    <div>
        @foreach($threads as $thread)
            <a href={{ route("thread", ["threadId" => $thread["id"]]) }}><h3>{{ $thread["title"] }}</h3></a>
        @endforeach
    </div>


    <div>
        ビューコンポーネント0915
        <p>作成した</p>
        x-header
        x-footer
        x-new-thread
        x-new-write
        <p>消した</p>
        x-application-logo
        x-primary-button
        x-secondary-button
        x-danger-button
        x-dropdown-link
        x-nav-link
        x-responsive-nav-link
        x-input-label
        x-text-input
        <p>未使用</p>
        x-auth-session-status
        x-dropdown
        x-input-error
        x-modal
    </div>
</body>
<x-footer></x-footer>