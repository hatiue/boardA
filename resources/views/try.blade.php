<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>CSSを試す</title>
</head>
<body>
    <button class="text-white bg-green-500 rounded p-1"><a href="{{ route('home') }}">掲示板へ戻る</a></button>
    <p class="text-lg">コンテナ</p>
        <div class="container">
            <p class="bg-green-100">container</pa>
        </div>
        
        <div class="container mx-auto">
            <p class="bg-green-200">container mx-auto</pa>
        </div>

        <div class="container mx-auto px-8">
            <p class="bg-green-300">container mx-auto px-8</pa>
        </div>

    <p class="text-lg">グリッド gap:行間</p>
        <p>grid grid-rows-2</p>
        <div class="grid grid-rows-2">
            <div class="bg-blue-100">1</div>
            <div class="bg-blue-200">2</div>
            <div class="bg-blue-300">3</div>
            <div class="bg-blue-400">4</div>
        </div>

        <p>grid grid-rows-2 grid-flow-col gap-1</p>
        <div class="grid grid-rows-2 grid-flow-col gap-1">
            <div class="bg-blue-100">1</div>
            <div class="bg-blue-200">2</div>
            <div class="bg-blue-300">3</div>
            <div class="bg-blue-400">4</div>
        </div>

        
    <p>フレックスボックス</p>
    <small>
        フレックスボックスが一次元であることは、フレックスボックスが一つの次元、つまり行か列のいずれかの方向にしかレイアウトしないことを述べています。
        これは CSS グリッドレイアウトが行と列の二次元を同時に制御するモデルであることと対照的です。
        https://developer.mozilla.org/ja/docs/Web/CSS/CSS_flexible_box_layout/Basic_concepts_of_flexbox
    </small>
        <div class="flex">
            
        </div>

</body>
</html>