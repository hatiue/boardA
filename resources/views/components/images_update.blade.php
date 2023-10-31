@props([
    'images' => []
])
<!-- 画像を表示する p231 -->
@if (count($images) > 0)
<div x-data="{}" class="px-2">
    <div class="flex justify-center -mx-2">
        @foreach ($images as $image)
            <div class="w-1/6 px-2 my-2">
                <div class="bg-gray-400">
                    <a @click="$dispatch('img-modal', { imgModalSrc: '{{ asset('storage/images/' . $image->name) }}' })" class="cursor-pointer" alt="現在の画像">
                        <img alt="{{ $image->name }}" class="object-fit w-full" src="{{ asset('storage/images/' . $image->name) }}">
                    </a>
                </div>

                <div>
                    <input type="file" name="newImage">
                    <button type="submit" class="border-dotted bg-blue-100 rounded-md px-2 py-1">
                            画像を変更（未実装）
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

@once
    <div x-data="{ imgModal : false, imgModalSrc : '' }">
        <div
            @img-modal.window="imgModal = true; imgModalSrc = $event.detail.imgModalSrc;"
            x-cloak
            x-show="imgModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform"
            x-transition:enter-end="opacity-100 transform"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform"
            x-transition:leave-end="opacity-0 transform"
            x-on:click.away="imgModalSrc = ''"
            class="p-2 fixed w-full h-100 inset-0 z-50 overflow-hidden flex justify-center items-center bg-black bg-opacity-75">
            <div @click.away="imgModal = ''" class="flex flex-col max-w-3xl max-h-full overflow-auto">
                <div class="z-50">
                    <button @click="imgModal = ''" class="float-right pt-2 pr-2 outline-none focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>
                    </button>
                </div>
                <div class="p-2">
                    <img
                        class="object-contain h-1/2-screen"
                        :alt="imgModalSrc"
                        :src="imgModalSrc">
                </div>
            </div>
        </div>
    </div>
    @push('css')
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @endpush
@endonce

