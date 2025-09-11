@extends('layouts.app')

@section('content')
    <div x-data="{ showBackTop: false, threshold: 0 }" x-init="threshold = $refs.firstSection ? $refs.firstSection.offsetHeight : 500" @scroll.window="showBackTop = window.scrollY > threshold">
        <div class="py-16" x-ref="firstSection">
            <section>
                <x-partials-home.section-1 />
            </section>
        </div>
        {{-- Разделитель секций с общей шириной контейнера --}}
        <div class="border-t-1 border-gray-300 dark:border-[#232325] w-full mx-auto"></div>
        {{-- Вторая секция (наши компетенции) — сразу после первой --}}
        <x-partials-home.section-2 />
        {{-- Разделитель секций --}}
        <div class="border-t-1 border-gray-300 dark:border-[#232325] w-full mx-auto"></div>
        {{-- Новости --}}
        <x-partials-home.section-news />
        {{-- Разделитель секций --}}
        <div class="border-t-1 border-gray-300 dark:border-[#232325] w-full mx-auto"></div>
        {{-- Третья секция (Лицензии и сертификаты) --}}
        <x-partials-home.section-3 :certificates="$certificates" />
        {{-- Разделитель секций --}}
        <div class="border-t-1 border-gray-300 dark:border-[#232325] w-full mx-auto"></div>
        {{-- Карта и информация о компании --}}
        <x-partials-home.section-map />


        <!-- Кнопка "Вверх" -->
        <button x-show="showBackTop" x-transition.opacity.scale @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            type="button" title="Наверх" aria-label="Наверх"
            class="group fixed bottom-1 md:bottom-10 right-4 md:right-6 z-50 rounded-full border border-[#51A3FF]/60 bg-white text-[#1E40AF] dark:bg-[#232325] dark:text-gray-100 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#51A3FF] p-[12px] md:p-[14px] transition transform hover:-translate-y-0.5 hover:scale-[1.3] cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.2" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19V5m0 0l-6 6m6-6l6 6" />
            </svg>
        </button>
    </div>
@endsection
