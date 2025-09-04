@props(['href' => '#'])

<a href="{{ $href }}"
    {{ $attributes->class('block px-4 py-2 m-2 font-semibold text-gray-900 dark:text-white hover:bg-gray-400/40 dark:hover:bg-gray-500/20 rounded-lg transition') }}>
    {{ $slot }}
</a>
