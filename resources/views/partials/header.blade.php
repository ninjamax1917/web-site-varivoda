<nav x-data="{ open: false }"
    class="relative bg-gray-100 dark:bg-gray-800 border-b-2 border-gray-700/70 dark:border-gray-700 after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <!-- Кнопка мобильного меню -->
            @include('partials.header.mobile_menu_button')
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <div class="flex shrink-0 items-center h-16">
                    <!-- Логотип -->
                    @include('partials.header.logo')
                </div>
                @include('partials.header.menu_header')
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                <!-- Здесь можно добавить кнопки профиля/уведомлений -->
                @include('partials.header.swiper_theme')
            </div>
        </div>
    </div>

    <!-- Мобильное меню -->
    @include('partials.header.mobile_menu')

</nav>
