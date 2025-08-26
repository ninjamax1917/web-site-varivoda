<nav x-data="{ open: false }"
    class="relative bg-gray-100 dark:bg-gray-800 after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <!-- Mobile menu button -->
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <button @click="open = !open" type="button"
                    class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-white/5 hover:text-white focus:outline-2 focus:-outline-offset-1 focus:outline-indigo-500">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Открыть главное меню</span>
                    <svg x-show="!open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                        aria-hidden="true" class="size-6">
                        <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <svg x-show="open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                        aria-hidden="true" class="size-6">
                        <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <div class="flex shrink-0 items-center h-16">
                    <!-- Логотип -->
                    @include('partials.header.logo')
                </div>
                <div class="hidden sm:ml-15 sm:flex items-center">
                    <div class="flex space-x-4">
                        <a href="#" aria-current="page"
                            class="rounded-md px-3 py-2 text-lg font-medium text-gray-800 dark:text-white hover:text-blue-800 dark:hover:text-blue-500">Главная</a>
                        <a href="#"
                            class="rounded-md px-3 py-2 text-lg font-medium text-gray-800 dark:text-white hover:text-blue-800 dark:hover:text-blue-500">Услуги</a>
                        <a href="#"
                            class="rounded-md px-3 py-2 text-lg font-medium text-gray-800 dark:text-white hover:text-blue-800 dark:hover:text-blue-500">Камеры
                            города</a>
                    </div>
                </div>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                <!-- Здесь можно добавить кнопки профиля/уведомлений -->
                @include('partials.header.swiper_theme')
            </div>
        </div>
    </div>

    <!-- Мобильное меню -->
    <div x-show="open" x-transition class="sm:hidden">
        <div class="space-y-1 px-2 pt-2 pb-3">
            <a href="#"
                class="block rounded-md bg-gray-950/50 px-3 py-2 text-base font-medium text-white hover:text-blue-500">Главная</a>
            <a href="#"
                class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-blue-500">Услуги</a>
            <a href="#"
                class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-blue-500">Камеры
                города</a>
        </div>
    </div>
</nav>
