@extends('layouts.app')

@section('title', 'Админ панель')

@section('content')
    <div class="max-w-5xl mx-auto py-10">
        <h1 class="text-3xl font-bold mb-8 text-center">Админ панель</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Панель мониторинга пользователей --}}
            <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow">
                <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Мониторинг пользователей</h2>
                <p class="mb-4 text-gray-600 dark:text-gray-300">Смотреть, кто и сколько времени смотрит трансляции, и
                    управлять доступом.</p>
                <a href="{{ route('auth.users.index') }}" class="btn btn-secondary">Открыть мониторинг</a>
            </div>
            {{-- Форма добавления камеры --}}
            <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow">
                <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Добавить камеру</h2>
                <form action="{{ route('admin.cameras.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-200">Название</label>
                        <input type="text" name="name"
                            class="input input-bordered w-full bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white border-gray-300 dark:border-gray-600 focus:border-blue-500 focus:ring-blue-500"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-200">RTSP URL</label>
                        <input type="text" name="rtsp_url"
                            class="input input-bordered w-full bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white border-gray-300 dark:border-gray-600 focus:border-blue-500 focus:ring-blue-500"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-200">Превью
                            (изображение)</label>
                        <input type="file" name="preview"
                            class="file-input file-input-bordered w-full bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white border-gray-300 dark:border-gray-600 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <button type="submit" class="btn btn-primary w-full">Добавить</button>
                </form>
            </div>

            {{-- Таблица камер --}}
            <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow overflow-x-auto">
                <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Список камер</h2>
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase">
                                ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase">
                                Название</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase">
                                RTSP URL</th>
                            <th
                                class="px-4 py-2 text-center text-xs font-medium text-gray-700 dark:text-gray-200 uppercase">
                                Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cameras as $camera)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-900">
                                <td class="px-4 py-2">{{ $camera->id }}</td>
                                <td class="px-4 py-2">{{ $camera->name }}</td>
                                <td class="px-4 py-2 break-all text-xs">{{ $camera->rtsp_url }}</td>
                                <td class="px-4 py-2 text-center">
                                    <form action="{{ route('admin.cameras.destroy', $camera) }}" method="POST"
                                        onsubmit="return confirm('Удалить камеру?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-error btn-xs">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 py-4">Камер пока нет.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
