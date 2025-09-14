<div class="relative avatar">
    <div
        class="w-72 h-72 rounded-full ring-2 ring-gray-500 overflow-hidden bg-gray-200 dark:bg-gray-700 flex items-center justify-center leading-none">
        @if (auth()->user()->avatar)
            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar"
                class="block object-cover object-center w-full h-full" />
        @else
            @include('auth.components-profile.avatar')
        @endif

        <!-- Dropdown с кнопками загрузки/удаления -->
        @include('auth.components-setting.partials.button-edit-avatar')
    </div>
</div>
