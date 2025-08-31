@extends('layouts.app')

@section('title', 'Профиль пользователя')

@section('content')
    <div class="flex items-center justify-center min-h-full py-16 bg-gray-50 dark:bg-gray-900">
        <div class="w-full max-w-3xl bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-8">Личный кабинет</h2>
            <div class="flex flex-col md:flex-row gap-22 pl-10">
                <!-- Левая колонка: аватар -->
                <div class="flex flex-col items-center md:w-1/3 w-full mb-6 md:mb-0">
                    @include('auth.components-setting.avatar')
                </div>
                <!-- Правая колонка: форма и кнопка выхода -->
                <div class="flex-1 flex flex-col gap-6">
                    @include('auth.components-setting.form')
                    @include('auth.components-setting.logout')
                </div>
            </div>
        </div>
    </div>
@endsection