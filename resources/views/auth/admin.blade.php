@extends('layouts.app')

@section('title', 'Админ панель')

@section('content')
    <div class="max-w-6xl mx-auto py-10">
        <h1 class="text-3xl font-bold mb-8 text-center">Админ панель</h1>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Блок: Мониторинг пользователей --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold">Мониторинг пользователей</h2>
                    <a href="{{ route('auth.users.index') }}" class="btn btn-secondary btn-sm">Открыть</a>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-300">Кто и сколько времени смотрит трансляции, блокировка
                    просмотра.</p>
            </div>

            {{-- Блок: Карточки услуг --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold">Карточки услуг</h2>
                    <a href="{{ route('auth.service_cards.index') }}" class="btn btn-secondary btn-sm">Управлять</a>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-300">Редактирование слайдеров на страницах услуг.</p>
            </div>

            {{-- Блок: Камеры — добавление --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold">Камеры</h2>
                    <a href="{{ route('admin.cameras.create') }}" class="btn btn-primary btn-sm">Добавить</a>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-300">Создание записи и регенерация конфигурации MediaMTX.</p>
            </div>
        </div>

        {{-- Таблица камер --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow overflow-x-auto mt-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold">Список камер</h2>
                <a href="{{ route('admin.cameras.create') }}" class="btn btn-primary btn-sm">+ Новая камера</a>
            </div>
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase">ID</th>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase">Название</th>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase">RTSP URL</th>
                        <th class="px-4 py-2 text-center text-xs font-medium uppercase">Действия</th>
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
@endsection
