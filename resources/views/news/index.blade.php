@extends('layouts.app')

@section('content')
    <section class="w-full py-10 md:py-14">
        <div class="mx-auto w-full max-w-[1440px] px-4 sm:px-6 lg:px-8">
            <h1
                class="text-3xl md:text-4xl font-bold mb-4 text-gray-900 dark:text-gray-100 border-l-4 border-[#51A3FF] pl-3">
                Новости компании
            </h1>

            <form method="get" class="grid grid-cols-1 md:grid-cols-4 gap-3 md:gap-4 mt-6 mb-8">
                <input type="text" name="q" value="{{ $search }}" placeholder="Поиск по новостям"
                    class="md:col-span-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#232325] text-gray-900 dark:text-gray-100 px-3 py-2 focus:ring-2 focus:ring-[#51A3FF] focus:outline-none" />
                <select name="category"
                    class="rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#232325] text-gray-900 dark:text-gray-100 px-3 py-2 focus:ring-2 focus:ring-[#51A3FF] focus:outline-none">
                    <option value="">Все категории</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}" @selected($category === $cat)>{{ $cat }}</option>
                    @endforeach
                </select>
                <button type="submit"
                    class="rounded-lg border border-[#51A3FF]/60 bg-white dark:bg-[#232325] text-gray-900 dark:text-gray-100 px-4 py-2 font-semibold hover:border-[#51A3FF] focus:ring-2 focus:ring-[#51A3FF]">Фильтр</button>
            </form>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse ($news as $item)
                    <a href="{{ route('news.show', $item->slug) }}"
                        class="block group rounded-2xl border border-gray-200 dark:border-white/10 overflow-hidden bg-white dark:bg-[#1b1b1d] hover:-translate-y-0.5 hover:shadow transition">
                        <div class="aspect-[16/9] w-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
                            @if ($item->cover_image)
                                <img src="{{ $item->cover_image }}" alt="{{ $item->title }}"
                                    class="w-full h-full object-cover" loading="lazy">
                            @endif
                        </div>
                        <div class="p-4">
                            @if ($item->category)
                                <span
                                    class="inline-block text-[10px] px-2 py-0.5 rounded bg-[#51A2FF] text-gray-900 font-semibold">{{ $item->category }}</span>
                            @endif
                            <h3 class="mt-2 text-lg md:text-xl font-semibold text-gray-900 dark:text-gray-100 line-clamp-2">
                                {{ $item->title }}</h3>
                            @if ($item->published_at)
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Дата публикации:
                                    {{ $item->published_at->format('d.m.Y') }}</div>
                            @endif
                            @if ($item->excerpt)
                                <p class="mt-2 text-sm text-gray-700 dark:text-gray-300 line-clamp-3">{{ $item->excerpt }}
                                </p>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-gray-700 dark:text-gray-300">Новостей пока нет.</div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $news->links() }}
            </div>
        </div>
    </section>
@endsection
