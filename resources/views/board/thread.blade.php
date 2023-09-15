<x-header></x-header>
<body>
<!-- 各スレッド個別ページ -->
    <h2>{{ $thread[0]["title"] }}</h2>
    @foreach($thread[1] as $elem)
        <div>
            <p><span>{{ $elem["num"] }}</span><span>{{ $elem["name"] }}</span></p>
            <p>{{ $elem["content"] }}</p>
        </div>
    @endforeach
    <x-new-write threadId="{{ $thread[0]['id'] }}"></x-new-write>
    
    <a href="{{ route('home') }}">トップへ戻る</a>
</body>
<x-footer></x-footer>