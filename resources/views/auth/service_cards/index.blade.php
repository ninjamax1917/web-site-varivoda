@extends('layouts.app')
@section('content')
    <div class="max-w-5xl mx-auto py-8">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-xl font-semibold">Карточки услуг</h1>
            <a href="{{ route('auth.service_cards.create') }}"
                class="px-3 py-1.5 rounded bg-blue-600 text-white text-sm">Добавить</a>
        </div>
        <div class="space-y-3">
            @foreach ($cards as $c)
                <div class="p-3 rounded border flex items-center justify-between">
                    <div>
                        <div class="font-medium">{{ $c->title }}</div>
                        <div class="text-xs text-gray-500">page: {{ $c->page }} · order: {{ $c->order }} · images:
                            {{ $c->images->count() }}</div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('auth.service_cards.edit', $c) }}"
                            class="px-2 py-1 text-sm rounded bg-gray-200">Редактировать</a>
                        <form method="POST" action="{{ route('auth.service_cards.destroy', $c) }}"
                            onsubmit="return confirm('Удалить карточку?')">
                            @csrf @method('DELETE')
                            <button class="px-2 py-1 text-sm rounded bg-red-600 text-white">Удалить</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
