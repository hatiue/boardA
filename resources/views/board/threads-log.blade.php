<x-header></x-header>
    <div class="flex-grow container mx-auto">

        @if (session("itsCurrent"))
            <p class="text-red-400">{{ session("itsCurrent") }}</p>
        @endif

        <h2 class="text-white text-xl mt-2">過去ログ一覧</h2>
        <p class="text-sm">過去ログにする条件は未定、flg_not_writable列が1ならここへ</p>
        <div>
            @foreach($threads as $thread)
                <div class="inline-block">
                    <span class="text-lg underline underline-offset-4">
                        <a href="{{ route('log-thread', ['threadId' => $thread['id']]) }}">
                            {{ $thread["title"] . "(" . $thread["count"] . ")" }}
                        </a>
                    </span>
                    <span class="text-sm">{{ "最終：" . $thread["time"] }}</span>
                </div>
            @endforeach
        </div>
        <x-button-top></x-button-top>
    </div>
    <x-footer></x-footer>
</body>
</html>