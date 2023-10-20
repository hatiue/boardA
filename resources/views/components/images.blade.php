@props([
    'images' => []
])
<!-- 画像を表示する p231 -->
@if (count($images) > 0)
<div x-data="{}" class="">
    <div class="px-2">
        @foreach ($images as $image)
            <div class="px-2 mt-5">
                <div class="bg-gray-400">
                    <a @click="$dispatch('img-modal', { imgModalSrc: '{{ asset('storage/images/' . $image->name) }}' })" class="cursor-pointer">
                        <img alt="{{ $image->name }}" class="object-fit w\-full" src="{{ asset('storage/images/' . $image->name) }}">
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif