<!-- 編集画面へ遷移する方 -->
<button type="submit" class="text-white bg-orange-400 hover:bg-orange-800 px-2 py-1 rounded-md">
    <a href="{{ route('update.index', ['writeId' => $writeId]) }}">
        編集
    </a>
</button>