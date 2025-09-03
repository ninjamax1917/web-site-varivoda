@extends('layouts.app')
@section('content')
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-xl font-semibold mb-4">{{ $card->exists ? 'Редактировать' : 'Создать' }} карточку</h1>
        <form method="POST"
            action="{{ $card->exists ? route('auth.service_cards.update', $card) : route('auth.service_cards.store') }}"
            enctype="multipart/form-data">
            @csrf
            @if ($card->exists)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <label class="block">Страница (slug)
                    @if (!empty($pages))
                        <select name="page" class="w-full mt-1 rounded border p-2">
                            @foreach ($pages as $p)
                                <option value="{{ $p['slug'] }}" @selected(old('page', $card->page) === $p['slug'])>
                                    {{ $p['name'] }} ({{ $p['slug'] }})
                                </option>
                            @endforeach
                        </select>
                    @else
                        <input name="page" class="w-full mt-1 rounded border p-2" value="{{ old('page', $card->page) }}"
                            placeholder="network" />
                    @endif
                </label>
                <label class="block md:col-span-2">Заголовок
                    <input name="title" class="w-full mt-1 rounded border p-2" value="{{ old('title', $card->title) }}" />
                </label>
                <label class="block">Порядок
                    <input name="order" type="number" min="0" class="w-full mt-1 rounded border p-2"
                        value="{{ old('order', $card->order) }}" />
                </label>
            </div>

            <div class="mt-6">
                <div class="flex items-center justify-between mb-2">
                    <div class="font-medium">Слайды</div>
                    <button type="button" id="add-image" class="px-2 py-1 rounded bg-gray-200 text-sm">Добавить
                        слайд</button>
                </div>
                <div id="images" class="space-y-2">
                    @php($initial = old('images', $card->images->toArray()))
                    @forelse ($initial as $i => $img)
                        <div class="grid grid-cols-1 md:grid-cols-6 gap-2 p-2 border rounded">
                            <input type="hidden" name="images[{{ $i }}][id]" value="{{ $img['id'] ?? '' }}" />
                            <div class="md:col-span-3 space-y-2">
                                <input name="images[{{ $i }}][path]" class="rounded border p-2 w-full"
                                    placeholder="/images/.../1.jpg" value="{{ $img['path'] ?? '' }}" />
                                <input type="file" name="images[{{ $i }}][file]"
                                    class="file-input file-input-bordered w-full" />
                                <p class="text-xs text-gray-500">Можно указать путь или загрузить файл (файл приоритетнее).
                                </p>
                            </div>
                            <input name="images[{{ $i }}][alt]" class="md:col-span-2 rounded border p-2"
                                placeholder="alt" value="{{ $img['alt'] ?? '' }}" />
                            <input name="images[{{ $i }}][order]" type="number" min="0"
                                class="rounded border p-2" value="{{ $img['order'] ?? 0 }}" />
                        </div>
                    @empty
                        {{-- Пустая форма для первого слайда --}}
                        <div class="grid grid-cols-1 md:grid-cols-6 gap-2 p-2 border rounded">
                            <div class="md:col-span-3 space-y-2">
                                <input name="images[0][path]" class="rounded border p-2 w-full"
                                    placeholder="/images/.../1.jpg" />
                                <input type="file" name="images[0][file]"
                                    class="file-input file-input-bordered w-full" />
                                <p class="text-xs text-gray-500">Можно указать путь или загрузить файл.</p>
                            </div>
                            <input name="images[0][alt]" class="md:col-span-2 rounded border p-2" placeholder="alt" />
                            <input name="images[0][order]" type="number" min="0" class="rounded border p-2"
                                value="0" />
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-6 flex gap-2">
                <button class="px-3 py-1.5 rounded bg-blue-600 text-white">Сохранить</button>
                <a href="{{ route('auth.service_cards.index') }}" class="px-3 py-1.5 rounded border">Отмена</a>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const add = document.getElementById('add-image');
                const wrap = document.getElementById('images');
                if (!add || !wrap) return;
                add.addEventListener('click', () => {
                    const i = wrap.children.length;
                    const div = document.createElement('div');
                    div.className = 'grid grid-cols-1 md:grid-cols-6 gap-2 p-2 border rounded';
                    div.innerHTML = `
            <div class="md:col-span-3 space-y-2">
                <input name="images[${i}][path]" class="rounded border p-2 w-full" placeholder="/images/.../1.jpg" />
                <input type="file" name="images[${i}][file]" class="file-input file-input-bordered w-full" />
                <p class="text-xs text-gray-500">Можно указать путь или загрузить файл.</p>
            </div>
            <input name="images[${i}][alt]" class="md:col-span-2 rounded border p-2" placeholder="alt" />
            <input name="images[${i}][order]" type="number" min="0" class="rounded border p-2" value="0" />
    `;
                    wrap.appendChild(div);
                });
            });
        </script>
    @endpush
@endsection
