@extends('layouts.app')

@section('content')
    <div class="mx-auto w-full max-w-[1200px] px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">Новости — админ</h1>
            <a href="{{ route('auth.news.create') }}"
                class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Новая новость</a>
        </div>

        <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#1b1b1d]">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-white/10">
                <thead class="bg-gray-50 dark:bg-[#232325]">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Заголовок</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Категория</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Опубликовано</th>
                        <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-white/10">
                    @foreach ($items as $it)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $it->title }}</div>
                                <div class="text-xs text-gray-500">/{{ $it->slug }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $it->category }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                {{ $it->is_published ? $it->published_at?->format('d.m.Y H:i') ?? 'да' : 'нет' }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('auth.news.edit', $it) }}"
                                    class="text-blue-600 hover:underline mr-3">Редактировать</a>
                                <form action="{{ route('auth.news.destroy', $it) }}" method="post" class="inline"
                                    onsubmit="return confirm('Удалить?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $items->links() }}</div>
    </div>
@endsection
