@extends('layouts.app')

@section('content')
    <div class="mx-auto w-full max-w-[900px] px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6">
            {{ $news->exists ? 'Редактирование новости' : 'Новая новость' }}
        </h1>

        @if (session('status'))
            <div class="mb-4 rounded-lg bg-emerald-50 text-emerald-800 px-4 py-2">{{ session('status') }}</div>
        @endif

        <form action="{{ $news->exists ? route('auth.news.update', $news) : route('auth.news.store') }}" method="post"
            enctype="multipart/form-data" class="space-y-4" x-data="{
                coverName: '',
                galleryNames: [],
                uploading: false,
                progress: 0,
                ajaxSubmit(e) {
                    this.uploading = true;
                    this.progress = 0;
                    const form = e.target;
                    const fd = new FormData(form);
                    const xhr = new XMLHttpRequest();
                    xhr.open(form.method || 'POST', form.action, true);
                    const token = document.querySelector('meta[name=csrf-token]')?.getAttribute('content');
                    if (token) xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    xhr.upload.onprogress = (ev) => {
                        if (!ev.lengthComputable) return;
                        this.progress = Math.round((ev.loaded / ev.total) * 100);
                    };
                    xhr.onload = () => {
                        this.uploading = false;
                        if (xhr.status >= 200 && xhr.status < 400) {
                            window.location.reload();
                        } else {
                            alert('Ошибка сохранения: ' + xhr.status);
                        }
                    };
                    xhr.onerror = () => {
                        this.uploading = false;
                        alert('Сеть недоступна или сервер не отвечает');
                    };
                    xhr.send(fd);
                }
            }" @submit.prevent="ajaxSubmit($event)">
            @csrf
            @if ($news->exists)
                @method('PUT')
            @endif

            <div>
                <label class="block text-sm font-medium mb-1">Заголовок</label>
                <input name="title" value="{{ old('title', $news->title) }}" required
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#232325] text-gray-900 dark:text-gray-100 px-3 py-2">
                @error('title')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-1">Категория</label>
                    <select name="category"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#232325] text-gray-900 dark:text-gray-100 px-3 py-2">
                        <option value="">— не выбрано —</option>
                        @foreach ($categories ?? [] as $cat)
                            <option value="{{ $cat }}" @selected(old('category', $news->category) === $cat)>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Обложка</label>
                <div class="flex items-center gap-3">
                    <input id="cover_image_file" type="file" name="cover_image_file" accept="image/*" class="sr-only"
                        @change="coverName = $event.target.files?.[0]?.name || ''">
                    <label for="cover_image_file"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#232325] cursor-pointer hover:bg-gray-50 dark:hover:bg-[#2a2a2d]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14m-7-7h14" />
                        </svg>
                        <span>Выберите файл</span>
                    </label>
                    @if ($news->cover_image)
                        <img src="{{ $news->cover_image }}" alt="cover"
                            class="h-10 w-16 object-cover rounded border border-gray-200 dark:border-gray-700">
                    @endif
                    <span x-show="coverName" class="text-sm text-gray-600 dark:text-gray-300" x-text="coverName"></span>
                </div>
                <p class="text-xs text-gray-500 mt-1">Поддерживаются: jpg, png, webp, gif. До 8 МБ.</p>
                <div x-show="uploading" class="mt-2 w-full h-2 bg-gray-200 dark:bg-gray-700 rounded">
                    <div class="h-2 bg-blue-600 rounded" :style="`width: ${progress}%`"></div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Краткое описание</label>
                <textarea name="excerpt" rows="2"
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#232325] text-gray-900 dark:text-gray-100 px-3 py-2">{{ old('excerpt', $news->excerpt) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Текст</label>
                <textarea name="body" rows="10" required
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#232325] text-gray-900 dark:text-gray-100 px-3 py-2">{{ old('body', $news->body) }}</textarea>
                @error('body')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-center gap-2">
                    <input id="is_published" type="checkbox" name="is_published" value="1" @checked(old('is_published', $news->is_published))
                        class="rounded border-gray-300 dark:border-gray-700">
                    <label for="is_published" class="text-sm">Опубликовано</label>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-1">Дата публикации</label>
                    <input type="datetime-local" name="published_at"
                        value="{{ old('published_at', optional($news->published_at)->format('Y-m-d\TH:i')) }}"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#232325] text-gray-900 dark:text-gray-100 px-3 py-2">
                </div>
            </div>

            <div class="pt-4">
                <button class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Сохранить</button>
                <a href="{{ route('auth.news.index') }}"
                    class="ml-3 text-gray-700 dark:text-gray-300 hover:underline">Отмена</a>
            </div>

            <div class="mt-10 border-t border-gray-200 dark:border-gray-700 pt-6">
                <h2 class="text-xl font-semibold mb-3">Галерея изображений</h2>
                @if ($news->exists && $news->images->count())
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                        @foreach ($news->images as $img)
                            <div class="rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                                <img src="{{ $img->path }}" alt="{{ $img->alt }}" class="w-full h-32 object-cover">
                                <div class="p-2 space-y-2">
                                    <input type="hidden" name="existing_gallery[{{ $img->id }}][id]"
                                        value="{{ $img->id }}">
                                    <input type="text" name="existing_gallery[{{ $img->id }}][alt]"
                                        value="{{ $img->alt }}" placeholder="ALT"
                                        class="w-full rounded border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#232325] text-sm px-2 py-1">
                                    <input type="number" name="existing_gallery[{{ $img->id }}][order]"
                                        value="{{ $img->order }}" placeholder="Порядок"
                                        class="w-full rounded border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#232325] text-sm px-2 py-1">
                                    <p class="text-xs text-gray-500">Чтобы удалить — не заполняйте ALT/Порядок и удалите
                                        позже, сохранение пересоберёт список; удаление происходит если картинка не передана
                                        в форме.</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <label class="block text-sm font-medium mb-2">Галерея — добавить изображения <span class="text-gray-500">(до
                        5 файлов за раз)</span></label>
                <input id="gallery_input" type="file" name="gallery[]" multiple accept="image/*" class="sr-only"
                    @change="
                        const files = Array.from($event.target.files || []);
                        if (files.length > 5) {
                            alert('Можно выбрать не более 5 файлов за один раз.');
                            $event.target.value = '';
                            galleryNames = [];
                        } else {
                            galleryNames = files.map(f => f.name);
                        }
                    ">
                <div class="mt-1 border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-700 bg-white/60 dark:bg-[#232325] p-6 text-center cursor-pointer hover:bg-gray-50 dark:hover:bg-[#2a2a2d]"
                    @click.prevent="document.getElementById('gallery_input').click()" @dragover.prevent @dragenter.prevent
                    @drop.prevent="
                        const dt = new DataTransfer();
                        let files = Array.from($event.dataTransfer.files || []).filter(f => f.type.startsWith('image/'));
                        if (files.length > 5) {
                            alert('Можно перетащить не более 5 изображений за один раз.');
                            files = files.slice(0, 5);
                        }
                        files.forEach(f => dt.items.add(f));
                        const input = document.getElementById('gallery_input');
                        input.files = dt.files;
                        galleryNames = Array.from(input.files).map(f => f.name);
                    ">
                    <div class="flex flex-col items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14m-7-7h14" />
                        </svg>
                        <div class="text-sm text-gray-700 dark:text-gray-300">Перетащите изображения сюда или нажмите,
                            чтобы выбрать файлы</div>
                        <div class="text-xs text-gray-500">Можно выбрать сразу несколько (до 5)</div>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2">Порядок определяется по очереди загрузки; можно задать вручную после
                    загрузки.</p>
                <ul class="mt-2 text-sm text-gray-600 dark:text-gray-300 list-disc list-inside"
                    x-show="galleryNames.length">
                    <template x-for="name in galleryNames" :key="name">
                        <li x-text="name"></li>
                    </template>
                </ul>
                <div x-show="uploading" class="mt-2 w-full h-2 bg-gray-200 dark:bg-gray-700 rounded">
                    <div class="h-2 bg-blue-600 rounded" :style="`width: ${progress}%`"></div>
                </div>
            </div>
        </form>
    </div>
@endsection
