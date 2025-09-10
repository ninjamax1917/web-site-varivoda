@php
    use App\Models\News;
    $latestNews = News::query()
        ->where('is_published', true)
        ->whereNotNull('published_at')
        ->orderByDesc('published_at')
        ->limit(3)
        ->get(['id', 'title', 'slug', 'excerpt', 'cover_image', 'published_at']);
@endphp

<section class="w-full py-12 md:py-16">
    <div class="mx-auto w-full max-w-[1440px] px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100 border-l-4 border-[#51A3FF] pl-3">
                Новости</h2>
            <a href="{{ route('news.index') }}"
                class="inline-flex items-center gap-1 text-sm font-semibold text-[#1E40AF] dark:text-[#DCEBFF] hover:underline">
                Все новости <span aria-hidden="true">→</span>
            </a>
        </div>
        @if ($latestNews->isEmpty())
            <p class="text-gray-700 dark:text-gray-300">Пока нет опубликованных новостей.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($latestNews as $n)
                    <a href="{{ route('news.show', $n->slug) }}"
                        class="group rounded-xl border border-[#51A3FF]/40 hover:border-[#51A3FF]/80 overflow-hidden bg-white dark:bg-[#232325] shadow-sm hover:shadow transition focus:outline-none focus:ring-2 focus:ring-[#51A3FF] focus:ring-offset-2 dark:focus:ring-offset-[#18181B]">
                        <div class="relative bg-gray-50 dark:bg-[#1B1B1D]">
                            @if ($n->cover_image)
                                <img src="{{ asset($n->cover_image) }}" alt="{{ $n->title }}"
                                    class="w-full h-44 object-cover">
                            @else
                                <div class="w-full h-44 grid place-items-center text-gray-400 dark:text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="w-8 h-8">
                                        <rect x="3" y="3" width="18" height="18" rx="2" />
                                        <path d="m3 14 4-4 4 4 5-5 5 5" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <div
                                class="flex items-center justify-between text-xs text-gray-600 dark:text-gray-400 mb-1">
                                <span>
                                    @if ($n->published_at)
                                        {{ $n->published_at->format('d.m.Y') }}
                                    @endif
                                </span>
                                <span
                                    class="inline-block text-[10px] px-2 py-0.5 rounded bg-[#51A3FF]/70 text-gray-900 font-semibold opacity-80 group-hover:opacity-100">Новость</span>
                            </div>
                            <h3
                                class="text-base font-semibold text-gray-900 dark:text-gray-100 line-clamp-2 group-hover:underline">
                                {{ $n->title }}</h3>
                            @if ($n->excerpt)
                                <p class="mt-1 text-sm text-gray-700 dark:text-gray-300 line-clamp-3">
                                    {{ $n->excerpt }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
