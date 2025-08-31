@extends('layouts.app')

@section('title', 'Профиль пользователя')

@section('content')
    <div class="flex items-center justify-center min-h-full py-16 bg-gray-50 dark:bg-gray-900">
        <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-6">Личный кабинет</h2>
            <div class="flex flex-col items-center mb-6">
                @include('auth.components-profile.avatar')
                <div class="mt-4 text-center">
                    <div class="text-lg font-semibold text-gray-800 dark:text-white">
                        {{ auth()->user()->name }}
                    </div>
                    <div class="text-gray-600 dark:text-gray-300">
                        Email: {{ auth()->user()->email }}
                    </div>
                    <div class="text-sm text-gray-500 mt-1">
                        Профиль создан: {{ auth()->user()->created_at->format('d.m.Y H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
