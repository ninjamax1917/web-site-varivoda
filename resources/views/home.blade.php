@extends('layouts.app')

@section('content')
    <div class="py-16">
        <section>
            <x-partials-home.section-1 />
        </section>
    </div>
    {{-- Разделитель секций с общей шириной контейнера --}}
            <div class="border-t-1 border-gray-300 dark:border-[#232325] w-full mx-auto"></div>
    {{-- Вторая секция (куб услуг) --}}
    <x-partials-home.section-2 />
    {{-- Разделитель секций --}}
    <div class="border-t-1 border-gray-300 dark:border-[#232325] w-full mx-auto"></div>
    {{-- Третья секция (Лицензии и сертификаты) --}}
    <x-partials-home.section-3 />
@endsection

