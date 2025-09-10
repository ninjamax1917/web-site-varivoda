<div class="relative avatar">
    <div
        class="w-72 h-72 rounded-full ring-2 ring-gray-500 overflow-hidden bg-gray-200 dark:bg-gray-700 grid place-items-center">
        @if (auth()->user()->avatar)
            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar"
                class="object-cover w-full h-full" />
        @else
            @if (auth()->user()->role === 'admin')
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="w-24 h-24 text-gray-700 dark:text-gray-200 transform translate-y-[20px]">
                    <path
                        d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                    <path d="M6.376 18.91a6 6 0 0 1 11.249.003" />
                    <circle cx="12" cy="11" r="4" />
                </svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="w-24 h-24 text-gray-700 dark:text-gray-200 transform translate-y-[20px]">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M8 14s1.5 2 4 2 4-2 4-2" />
                    <line x1="9" x2="9.01" y1="9" y2="9" />
                    <line x1="15" x2="15.01" y1="9" y2="9" />
                </svg>
            @endif
        @endif
    </div>
</div>
