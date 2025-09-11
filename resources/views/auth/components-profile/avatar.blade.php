<div class="relative avatar">
    <div
        class="w-72 h-72 rounded-full ring-2 ring-gray-500 overflow-hidden bg-gray-200 dark:bg-gray-700 flex items-center justify-center leading-none">
        @if (auth()->user()->avatar)
            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar"
                class="block object-cover object-center w-full h-full" />
        @else
            <img src="{{ asset('images/icons/default_avatar.jpg') }}" alt="Default avatar"
                class="block object-cover object-center w-full h-full" />
        @endif
    </div>
</div>
