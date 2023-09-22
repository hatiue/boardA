<x-header></x-header>
<body>
<!-- 各スレッド個別ページ -->
    <h2>{{ $thread[0]["title"] }}</h2>
    @if (session('delete.success'))
        <!-- 投稿が元々あった位置に出したいが -->
        <p style="color: green">{{ session('delete.success') }}</p>
    @endif
    @foreach($thread[1] as $elem)
        <div>
            <p><span>{{ $elem["num"] }}</span><span>{{ $elem["name"] }}</span></p>
            <p>{{ $elem["content"] }}</p>
            <p><span>投稿時間：{{ $elem["created_at"] }}</span>
                @if ($elem["created_at"] != $elem["updated_at"])
                    <span>更新時間：{{ $elem["updated_at"] }}</span>
                @endif
            </p>
            @if ($elem["content"] !==  "この投稿は削除されました。")
                <!-- 完全一致の投稿があると削除と同一処理になる、ボタンを隠しても直接URLを触れば編集できてしまう（たぶん） -->
                <!-- 削除（編集不可）フラグを追加する？ -->
                @auth
                    <a href="{{ route('update.index', ['writeId' => $elem['write_id']]) }}">編集</a>
                @endauth
            @endif
            <form action="{{ route('write.delete', ['writeId' => $elem['write_id']]) }}" method="post">
                @method('DELETE')    
                @csrf
                <button type="submit">削除</button>
            </form>
        </div>
    @endforeach
    <x-new-write threadId="{{ $thread[0]['id'] }}"></x-new-write>
    <button>
        <a href="{{ route('home') }}">トップへ戻る</a>
    </button>
</body>
<x-footer></x-footer>