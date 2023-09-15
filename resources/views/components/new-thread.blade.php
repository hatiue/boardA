<!-- スレ立てフォーム -->
<div>
    <p><b>新規スレッド</b></p>
    <form action="{{ route('create') }}" method="post">
        @csrf
        <label for="title"><span>スレッドタイトル</span></label>
        <input id="title" type="text" name="title" maxlength="64"><br>
        @error('title', 'content')
        <p style="color: red;">{{ $message }}</p>
        @enderror
        <label for="content"><span>1の書き込み</span></label>
        <textarea id="content" type="text" name="content"></textarea>

        
        <div>
            <p>Todo:↓このチェックボックスは動作確認後authで囲む↓</p>
            <input id="flg_anonymous" type="checkbox" name="flg_anonymous" checked>
            <label for="flg_anonymous">匿名で書き込む</label>
        </div>
        

        <button type="submit">投稿</button>
    </form>
</div>