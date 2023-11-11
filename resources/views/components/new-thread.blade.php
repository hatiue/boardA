<!-- スレ立てフォーム -->
<div>
    <h2 class="text-white text-xl font-semibold mt-2">新規スレッド作成</h2>
    <form action="{{ route('create') }}" method="post" enctype="multipart/form-data">
        @csrf
        <label for="title"><span class="font-semibold">スレッドタイトル</span></label>
        <input id="title" type="text" name="title" maxlength="64" class="block rounded focus:ring-2 focus:ring-orange-400 p-1"><br>
        @error('title', 'content')
        <p style="color: red;">{{ $message }}</p>
        @enderror
        <label for="content"><span class="font-semibold">1の書き込み(256文字まで)</span></label>
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