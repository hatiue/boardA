<x-header></x-header>
<body>
<!-- 各スレッド個別ページ -->
<div class="min-h-screen flex flex-col">
    <div class="container mx-auto">
        <h2 class="text-xl">{{ $thread[0]["title"] }}</h2>
        <!-- 投稿が元々あった位置に出したいが -->
        @if (session('delete.success'))
            <p style="color: green;">{{ session('delete.success') }}</p>
        @endif
        @if (session('feedback.failure'))
            <p style="color: red;">{{ session('feedback.failure') }}</p>
        @endif
        @foreach($thread[1] as $elem)
            <div id="{{ 'id' . $elem['num'] }}" class="my-1">
                <p><span>{{ $elem["num"] . "：" }}</span><span>{{ $elem["name"] }}</span></p>
                <p>{!! $elem["content"] !!}</p>
                <p>{{ "原文：" . $elem["content"] }}</p>
                <div class="border border-dotted">
                    <p>画像表示枠、無ければ無い</p>
                    <x-images :images="$elem['images']"></x-images>
                </div>
                <p><span>投稿時間：{{ $elem["created_at"] }}</span>
                    @if ($elem["created_at"] != $elem["updated_at"])
                        <span>更新時間：{{ $elem["updated_at"] }}</span>
                    @endif
                </p>
                @auth
                    @if ($elem["flg_deleted"] == 0 && auth()->id() == $elem["user_id"])
                        @if ($elem["flg_anonymous"] === 0)
                            <x-button-update :writeId="$elem['write_id']"></x-button-update>
                        @endif
                        <form action="{{ route('write.delete', ['writeId' => $elem['write_id']]) }}" method="post">
                            @method('DELETE')    
                            @csrf
                            <x-button-delete></x-button-delete>
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
        <x-button-top></x-button-top>
    </div>
    個別ページ最下部
    <x-footer></x-footer>
</div>
</body>