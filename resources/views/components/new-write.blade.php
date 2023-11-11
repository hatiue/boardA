<!-- 書き込みフォーム -->
<div>
    <p class="text-white text-xl font-semibold mt-2">新規書き込み</p>
    <form action="{{ route('write', ['threadId' => $threadId]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @error('content')
        <p style="color: red;">{{ $message }}</p>
        @enderror

        <label for="content"><span>投稿内容(256文字まで)</span></label>
        <textarea
            id="content"
            type="text"
            name="content"
            rows="3"
            maxlength="256"
            class="block rounded focus:ring-2 focus:ring-orange-400"></textarea>
            <x-form.images></x-form.images>
        <div>
            <p>↓ログイン時のみここにチェックボックスが出る↓</p>
            @auth
            <input id="flg_anonymous" type="checkbox" name="flg_anonymous" class="checked:text-red-600" checked>
            <label for="flg_anonymous"><span>匿名で書き込む</span></label>
            @endauth
        </div>

        <x-button-write></x-button-write>
    </form>
</div>