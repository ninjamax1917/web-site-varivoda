<div class="relative avatar">
    <div class="w-72 rounded-full ring-2 ring-gray-500 overflow-hidden">
        @if (auth()->user()->avatar)
            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar"
                class="object-cover w-full h-full" />
        @else
            <img src="{{ asset('images/default_avatar.gif') }}" alt="Avatar" class="object-cover w-full h-full" />
        @endif
    </div>
</div>
