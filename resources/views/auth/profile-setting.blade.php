@extends('layouts.app')

@section('title', 'Настройка профиля')

@section('content')
    <section class="w-full py-12 md:py-16">
        <div class="mx-auto w-full max-w-[1440px] px-4 sm:px-6 lg:px-8">
            <h2
                class="text-3xl md:text-4xl font-bold mb-6 text-gray-900 dark:text-gray-100 border-l-4 border-[#51A3FF] pl-3">
                Редактировать профиль
            </h2>

            <div
                class="mx-auto w-full max-w-5xl rounded-2xl ring-1 ring-gray-300 dark:ring-white/10 bg-white dark:bg-[#232325] shadow-sm p-6 sm:p-8">
                <div class="flex flex-col md:flex-row gap-10">
                    <!-- Левая колонка: аватар -->
                    <div class="flex flex-col items-center md:w-1/3 w-full mb-6 md:mb-0">
                        @include('auth.components-setting.avatar')
                        @if ($errors->has('avatar'))
                            <div class="text-red-500 text-sm mt-2">
                                {{ $errors->first('avatar') }}
                            </div>
                        @endif
                    </div>
                    <div class="hidden md:block border-l border-gray-200/70 dark:border-white/10 mx-8"></div>
                    <!-- Правая колонка: форма и кнопка выхода -->
                    <div class="flex flex-col gap-6 md:w-2/3 w-full">
                        @include('auth.components-setting.form')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
