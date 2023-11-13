<!-- 過去ログとして表示するスレッド、書き込み不可 -->
<x-header></x-header>
<body>
<div class="flex-grow container mx-auto">
    <h2 class="text-xl">{{ $thread[0]["title"] }}</h2>
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
        </div>
    @endforeach
    <x-button-top></x-button-top>
    <x-button-log></x-button-log>
</div>
<x-footer></x-footer>
</body>