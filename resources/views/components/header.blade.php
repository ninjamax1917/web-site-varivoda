<nav x-data="{ open: false }" class="relative bg-gray-100 dark:bg-gray-800 shadow-lg">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <!-- Кнопка мобильного меню -->
            <x-partials.header.mobile-menu-button />
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <div class="flex shrink-0 items-center h-16">
                    <!-- Логотип -->
                    <x-partials.header.logo />
                </div>
                <x-partials.header.menu-header />
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                <!-- Здесь можно добавить кнопки профиля/уведомлений -->
                <x-partials.header.swiper-theme />
            </div>
        </div>
    </div>

    <!-- Мобильное меню -->
    <x-partials.header.mobile-menu />

</nav>
