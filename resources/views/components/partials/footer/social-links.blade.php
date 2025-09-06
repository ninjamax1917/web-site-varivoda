@php
    $icons = include resource_path('data/social-links.php');
@endphp

<div class="flex items-center gap-8">
    @foreach ($icons as $item)
        @php
            $component = 'icons.' . ($item['icon'] ?? '');
        @endphp
        <a href="{{ $item['href'] ?? '#' }}"
           class="hover:text-blue-600 dark:hover:text-blue-500 transition-colors duration-400"
           aria-label="{{ $item['label'] ?? '' }}"
           title="{{ $item['label'] ?? '' }}">
            <x-dynamic-component :component="$component" />
        </a>
    @endforeach
</div>