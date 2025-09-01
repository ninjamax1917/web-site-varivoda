@extends('layouts.app')

@section('title', 'Настройка профиля')

@section('content')
    <div class="flex items-center justify-center min-h-full py-16 bg-gray-50 dark:bg-gray-900">
        <div class="w-full max-w-4xl bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-8">Редактировать профиль</h2>
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
                <div class="hidden md:block border-l border-gray-300 dark:border-gray-700 mx-8"></div>
                <!-- Правая колонка: форма и кнопка выхода -->
                <div class="flex flex-col gap-6 md:w-2/3 w-full">
                    @include('auth.components-setting.form')
                </div>
            </div>
        </div>
    </div>
@endsection
