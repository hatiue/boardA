<x-header></x-header>
<body>
<!-- 各スレッド個別ページ -->
    <h2>{{ $thread[0]["title"] }}</h2>
    @foreach($thread[1] as $elem)
        <div>
            <p><span>{{ $elem["num"] }}</span><span>{{ $elem["name"] }}</span></p>
            <p>{{ $elem["content"] }}</p>
            <p><span>投稿時間：{{ $elem["created_at"] }}</span>
                @if ($elem["created_at"] != $elem["updated_at"])
                    <span>更新時間：{{ $elem["updated_at"] }}</span>
                @endif
            </p>
            <a href="{{ route('update.index', ['writeId' => $elem['write_id']]) }}">編集</a>
        </div>
    @endforeach
    <x-new-write threadId="{{ $thread[0]['id'] }}"></x-new-write>
    <button>
        <a href="{{ route('home') }}">トップへ戻る</a>
    </button>
</body>
<x-footer></x-footer>