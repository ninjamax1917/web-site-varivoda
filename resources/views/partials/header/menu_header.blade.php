<div class="hidden sm:ml-15 sm:flex items-center">
    <div class="flex space-x-4"> <a href="#" aria-current="page"
            class="rounded-md px-3 py-2 text-lg font-medium text-gray-800 dark:text-white hover:text-blue-800 dark:hover:text-blue-500">Главная</a>
        <div x-data="{ open: false }" class="relative"> <button @click="open = !open"
                class="rounded-md px-3 py-2 text-lg font-medium text-gray-800 dark:text-white hover:text-blue-800 dark:hover:text-blue-500 flex items-center">
                Услуги <svg
                    :class="{ 'transform transition-transform duration-500 rotate-360': open, 'transform transition-transform duration-500':
                            !open }"
                    class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg> </button>
            <div x-show="open" @click.away="open = false"
                class="absolute left-0 mt-2 w-80 rounded-md shadow-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 z-50 overflow-hidden"
                x-transition>
                @foreach ($services as $service)
                    <a href="#"
                        class="block px-4 py-2 font-semibold text-gray-900 dark:text-white hover:bg-gray-400/40 dark:hover:bg-gray-600">
                        {{ $service }} </a>
                @endforeach
            </div>
        </div> <a href="#"
            class="rounded-md px-3 py-2 text-lg font-medium text-gray-800 dark:text-white hover:text-blue-800 dark:hover:text-blue-500">Камеры
            города</a>
    </div>
</div>
