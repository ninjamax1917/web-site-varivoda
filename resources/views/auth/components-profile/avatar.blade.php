<div class="relative avatar">
    <div
        class="w-72 h-72 rounded-full ring-2 ring-gray-500 overflow-hidden bg-gray-200 dark:bg-gray-700 flex items-center justify-center leading-none">
        @if (auth()->user()->avatar)
            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar"
                class="block object-cover object-center w-full h-full" />
        @else
            @include('components.icons.default_avatar_svg', ['class' => 'w-full h-full mx-auto mt-1 text-gray-700 dark:text-gray-400'])
        @endif
    </div>
</div>