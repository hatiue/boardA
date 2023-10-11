<x-header></x-header>
<body>
<!-- 各スレッド個別ページ -->
    <h2>{{ $thread[0]["title"] }}</h2>
    <!-- 投稿が元々あった位置に出したいが -->
    @if (session('delete.success'))
        <p style="color: green;">{{ session('delete.success') }}</p>
    @endif
    @if (session('feedback.failure'))
        <p style="color: red;">{{ session('feedback.failure') }}</p>
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
            @auth
                @if ($elem["flg_deleted"] == 0 && auth()->id() == $elem["user_id"])
                    @if ($elem["flg_anonymous"] === 0)
                        <button style="background-color: #ffd700; border: none; border-radius: 4px;"><a href="{{ route('update.index', ['writeId' => $elem['write_id']]) }}">編集</a></button>
                    @endif
                    <form action="{{ route('write.delete', ['writeId' => $elem['write_id']]) }}" method="post">
                        @method('DELETE')    
                        @csrf
                        <button type="submit">削除</button>
                    </form>
                @endif
            @endauth
        </div>
    @endforeach
    @if (count($thread[1]) < $upperLimit)
        <x-new-write threadId="{{ $thread[0]['id'] }}"></x-new-write>
    @else
        <div style="color: red;">
            <p>{{ $upperLimit }}が書き込み上限に設定されているため、書き込みフォームが表示できません</p>
            <p>トップに戻って次のスレッドを立てましょう！</p>
        </div>
    @endif
    <button>
        <a href="{{ route('home') }}">トップへ戻る</a>
    </button>
</body>
<x-footer></x-footer>