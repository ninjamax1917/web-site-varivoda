@extends('layouts.app')

@section('content')
    <section class="w-full py-10 md:py-14">
        <div class="mx-auto w-full max-w-[960px] px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('news.index') }}" class="text-sm text-blue-700 dark:text-blue-300 hover:underline">← Ко всем
                    новостям</a>
            </div>

            <h1 class="text-3xl md:text-4xl font-bold mb-3 text-gray-900 dark:text-gray-100">{{ $item->title }}</h1>
            <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400 mb-6">
                @if ($item->published_at)
                    <span>Дата публикации: {{ $item->published_at->format('d.m.Y H:i') }}</span>
                @endif
                @if ($item->category)
                    <span
                        class="inline-block text-[10px] px-2 py-0.5 rounded bg-[#51A2FF] text-gray-900 font-semibold">{{ $item->category }}</span>
                @endif
            </div>

            @php
                $__cover = null;
                if (!empty($item->cover_image)) {
                    $__cover = ['src' => asset($item->cover_image), 'alt' => $item->title];
                }
                $__gallery = [];
                foreach ($item->images as $__g) {
                    $__gallery[] = ['src' => asset($__g->path), 'alt' => $__g->alt ?: $item->title];
                }
            @endphp

            <script>
                // Инициализатор компонента Alpine для просмотра изображений
                function newsViewer(el) {
                    let gallery = []
                    let cover = null
                    try {
                        const g = el.querySelector('script[data-gallery]')
                        if (g) gallery = JSON.parse(g.textContent || '[]')
                    } catch (e) {
                        gallery = []
                    }
                    try {
                        const c = el.querySelector('script[data-cover]')
                        if (c) cover = JSON.parse(c.textContent || 'null')
                    } catch (e) {
                        cover = null
                    }
                    return {
                        open: false,
                        index: 0,
                        images: [],
                        gallery,
                        cover,
                        // touch swipe state
                        _touchStartX: 0,
                        _touchStartY: 0,
                        _touchTime: 0,
                        _swiping: false,
                        openCover() {
                            this.images = this.cover ? [this.cover] : [];
                            this.index = 0;
                            this.open = this.images.length > 0
                        },
                        openAt(i) {
                            this.images = this.gallery;
                            this.index = i;
                            this.open = true
                        },
                        close() {
                            this.open = false
                        },
                        next() {
                            if (!this.open || !this.images.length) return;
                            this.index = (this.index + 1) % this.images.length
                        },
                        prev() {
                            if (!this.open || !this.images.length) return;
                            this.index = (this.index - 1 + this.images.length) % this.images.length
                        },
                        onTouchStart(e) {
                            if (!this.open) return;
                            const t = e.touches && e.touches[0] ? e.touches[0] : e;
                            this._touchStartX = t.clientX;
                            this._touchStartY = t.clientY;
                            this._touchTime = Date.now();
                            this._swiping = true;
                        },
                        onTouchMove(e) {
                            // Опционально: визуальная обратная связь
                        },
                        onTouchEnd(e) {
                            if (!this._swiping) return;
                            this._swiping = false;
                            const t = e.changedTouches && e.changedTouches[0] ? e.changedTouches[0] : e;
                            const dx = t.clientX - this._touchStartX;
                            const dy = t.clientY - this._touchStartY;
                            const threshold = 40; // px
                            if (Math.abs(dx) > Math.abs(dy) && Math.abs(dx) > threshold) {
                                dx < 0 ? this.next() : this.prev();
                            }
                        },
                    }
                }
            </script>

            <div x-data="newsViewer($el)" @keydown.window.escape="close()" @keydown.window.arrow-right.prevent="next()"
                @keydown.window.arrow-left.prevent="prev()">
                <!-- JSON data for Alpine (not rendered) -->
                <script type="application/json" data-gallery>@json($__gallery)</script>
                @if ($__cover)
                    <script type="application/json" data-cover>@json($__cover)</script>
                @endif
                @if ($__cover)
                    <!-- Обложка отдельно -->
                    <div class="mt-4">
                        <button type="button"
                            class="block w-full rounded overflow-hidden border border-gray-200 dark:border-gray-700 focus:outline-none"
                            @click="openCover()" title="Открыть обложку">
                            <img src="{{ $__cover['src'] }}" alt="{{ $__cover['alt'] }}"
                                class="w-full h-auto object-cover max-h-[65vh]">
                        </button>
                    </div>
                @endif

                @if (!empty($__gallery))
                    <div class="mt-4 overflow-x-auto">
                        <div class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Галерея изображений</div>
                        <div class="flex gap-4 py-1">
                            @foreach ($__gallery as $__i => $__it)
                                <button type="button"
                                    class="shrink-0 rounded overflow-hidden border border-gray-200 dark:border-gray-700 hover:opacity-95 focus:outline-none w-56 h-40"
                                    @click="openAt({{ $__i }})" title="Открыть изображение">
                                    <img src="{{ $__it['src'] }}" alt="{{ $__it['alt'] }}"
                                        class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Модальное окно fullscreen с навигацией -->
                <div x-show="open" x-transition.opacity
                    class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4" @click.self="close()"
                    @touchstart.passive="onTouchStart($event)" @touchmove.passive="onTouchMove($event)"
                    @touchend.passive="onTouchEnd($event)" style="display: none;">
                    <button class="absolute top-4 right-4 text-white/80 hover:text-white text-2xl" @click="close()"
                        aria-label="Закрыть">✕</button>
                    <template x-if="images.length > 1">
                        <button class="absolute left-4 md:left-6 text-white/80 hover:text-white text-3xl px-2"
                            @click.stop="prev()" aria-label="Предыдущее">‹</button>
                    </template>
                    <img :src="images[index] ? images[index].src : ''" :alt="images[index] ? images[index].alt : ''"
                        class="max-h-[90vh] max-w-[95vw] object-contain">
                    <template x-if="images.length > 1">
                        <button class="absolute right-4 md:right-6 text-white/80 hover:text-white text-3xl px-2"
                            @click.stop="next()" aria-label="Следующее">›</button>
                    </template>
                </div>
            </div>

            <article class="mt-8 text-base md:text-lg leading-relaxed text-gray-800 dark:text-gray-100">
                {!! nl2br(e($item->body)) !!}
            </article>

            <div class="mt-10 flex items-center justify-between text-sm">
                <div>
                    @if ($prev)
                        <a href="{{ route('news.show', $prev->slug) }}" class="hover:underline">← {{ $prev->title }}</a>
                    @endif
                </div>
                <div>
                    @if ($next)
                        <a href="{{ route('news.show', $next->slug) }}" class="hover:underline">{{ $next->title }} →</a>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
