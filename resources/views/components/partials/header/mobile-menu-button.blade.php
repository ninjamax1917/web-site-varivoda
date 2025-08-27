<div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
    <button @click="open = !open" type="button"
        class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-white/5 hover:text-white focus:outline-2 focus:-outline-offset-1 focus:outline-indigo-500">
        <span class="absolute -inset-0.5"></span>
        <span class="sr-only">Открыть главное меню</span>
        <svg x-show="!open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"
            class="size-6">
            <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <svg x-show="open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
            aria-hidden="true" class="size-6">
            <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>
</div>
