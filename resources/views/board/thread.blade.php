<x-header></x-header>
<body>
<!-- 各スレッド個別ページ -->
<div class="flex-grow container mx-auto">
    <h2 class="text-xl">{{ $thread[0]["title"] }}</h2>
    
    @if (session('delete.success'))
        <p style="color: green;">{{ session('delete.success') }}</p>
    @endif
    @if (session('feedback.failure'))
        <p style="color: red;">{{ session('feedback.failure') }}</p>
    @endif
    @foreach($thread[1] as $elem)
    
        <div id="{{ 'id' . $elem['num'] }}" class="my-1">
            <p><span>{{ $elem["num"] . "：" }}</span><span>{{ $elem["name"] }}</span></p>

            <div>
                @if (is_array($elem["content"]))
                    @foreach ($elem["content"] as $content)
                        @if (is_numeric($content))
                            <?php $anchor = (int) $content ?>
                            <p>
                                <a href={{ "#id" . $anchor }}>{{ ">>" . $anchor }}</a>
                            </p>
                        @else
                            <span>{{ $content }}</span>
                        @endif
                    @endforeach
                @else
                    <p>{{ $elem["content"] }}</p>
                @endif
            </div>

            <?php $count_images = count($elem['images']) ?>
            @if ($count_images > 0)
                <div class="border border-dotted">
                    <p class="text-sm">{{ $count_images }}枚の画像</p>
                    <x-images :images="$elem['images']"></x-images>
                </div>
            @endif
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
<x-footer></x-footer>
</body>