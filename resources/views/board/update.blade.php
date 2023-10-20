<x-header></x-header>
<body>
<!-- 個別編集ページ -->
@auth
<h2>ここにスレッドタイトルを表示予定</h2>
    <div>
        <p>投稿内容を編集</p>
        <form action="{{ route('update.put', ['writeId' => $write->id]) }}" method="post">
            @method('PUT')
            @csrf
            <textarea type="text" name="content">{{ $write->content }}</textarea>
            <x-button-updated></x-button-updated>
            @if (session('feedback.success'))
                <p style="color: green;">{{ session('feedback.success') }}</p>
            @endif
            @error('content')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </form>
    </div>
    <x-button-back :threadId="$write->thread_id"></x-button-back>
    <x-button-top></x-button-top>
@endauth
@guest
<p>投稿の編集はログイン限定です</p>
@endguest
</body>
<x-footer></x-footer>