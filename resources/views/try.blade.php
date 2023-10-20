<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        <div class="flex">
            
        </div>

    <p>フロート</p>
</body>
</html>