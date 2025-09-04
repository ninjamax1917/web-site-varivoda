@props(['title', 'images' => []])
<div class="card bg-gray-200/70 dark:bg-[#232325]/50 w-96 shadow-lg">
    <div class="swiper">
        <div class="swiper-wrapper">
            @foreach ($images as $img)
                <div class="swiper-slide">
                    <img src="{{ $img['path'] ?? $img->path }}" alt="{{ $img['alt'] ?? ($img->alt ?? 'Фото') }}" />
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
    <div class="flex items-center justify-center h-20">
        <h2 class="text-lg text-center text-gray-800 dark:text-gray-100">{{ $title }}</h2>
    </div>
</div>
