<div
    class="select-none fixed top-0 left-0 bg-gray-200 dark:bg-[#232325] dark:text-gray-100 h-screen w-80 p-4 z-50 flex flex-col overflow-y-auto">
    @auth
    <a href="{{ route('profile') }}"
        class="flex items-center justify-center gap-2 text-center rounded-lg px-3 py-2 text-base font-semibold text-blue-700 dark:text-blue-200 bg-white dark:bg-gray-700 shadow hover:bg-blue-50 dark:hover:bg-gray-600 transition duration-400 mt-4 [@media(min-width:530px)]:hidden">
        @if (auth()->user()->avatar)
            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar"
                class="w-7 h-7 rounded-full object-cover object-center" />
        @else
            @include('components.icons.default_avatar_svg', ['class' => 'w-7 h-7'])
        @endif
        Профиль
    </a>
@endauth
    <div class="space-y-1 px-2 pt-2 pb-3 flex-1 flex flex-col">
        <a href="{{ route('home') }}"
            class="text-base text-center block rounded-md px-3 py-2 font-medium text-gray-900 dark:text-gray-100 hover:bg-white/5 hover:text-blue-500 transition duration-400">Главная</a>
        <div x-data="{ subOpen: true }" class="relative">
            <button @click="subOpen = !subOpen"
                class="w-full text-base text-center block rounded-md px-3 py-2 font-medium text-gray-900 dark:text-gray-100 hover:bg-white/5 hover:text-blue-500 transition duration-600">
                Услуги
                <svg :class="{ 'rotate-540': subOpen }"
                    class="inline-block ml-1 h-4 w-4 transition-transform duration-300" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            {{-- Подчеркивание --}}
            <div x-show="subOpen" class="w-full flex justify-center">
                <span class="block h-0.5 w-1/3 bg-blue-500 rounded transition-all duration-300 -mt-1 -ml-1"></span>
            </div>
            <div x-show="subOpen" x-transition class="mt-1 space-y-1">
                @isset($services)
                    @foreach ($services as $service)
                        <a href="{{ route('service.show', $service['slug']) }}"
                            class="text-center block rounded-md px-3 py-2 text-base font-medium text-gray-900 dark:text-gray-100 hover:bg-white/10 hover:text-blue-500 transition duration-400">
                            {{ $service['name'] }}
                        </a>
                    @endforeach
                @endisset
            </div>
        </div>
        <a href="{{ route('cctv-city.index') }}"
            class="mt-4 text-center block rounded-md px-3 py-2 text-base font-medium text-gray-900 dark:text-gray-200 hover:bg-white/5 hover:text-blue-500 transition duration-400">Камеры
            города</a>

        <a href="{{ route('news.index') }}"
            class="text-center block rounded-md px-3 py-2 text-base font-medium text-gray-900 dark:text-gray-100 hover:bg-white/5 hover:text-blue-500 transition duration-400">Новости</a>



        @guest
            <div class="my-6 border-t-1 border-gray-700 rounded-full"></div>
            <a href="{{ route('login') }}"
                class="flex items-center justify-center gap-2 text-center rounded-lg px-3 py-2 text-base font-semibold text-green-700 dark:text-green-300 bg-white dark:bg-gray-700 shadow hover:bg-green-50 dark:hover:bg-gray-600 transition duration-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700 dark:text-green-300" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                </svg>
                Вход
            </a>
            <a href="{{ route('register') }}"
                class="mt-1 flex items-center justify-center gap-2 text-center rounded-lg px-3 py-2 text-base font-semibold text-blue-700 dark:text-blue-200 bg-white dark:bg-gray-700 shadow hover:bg-blue-50 dark:hover:bg-gray-600 transition-all duration-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-user-pen-icon lucide-user-pen">
                    <path d="M11.5 15H7a4 4 0 0 0-4 4v2" />
                    <path
                        d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                    <circle cx="10" cy="7" r="4" />
                </svg>
                Регистрация
            </a>
        @endguest

        <div class="pt-4 mt-10">
            @include('components.partials.header.swiper-theme-mobile')
        </div>
        <div class="pt-4 mt-auto">
            <a href="{{ route('policy') }}"
                class="text-center block rounded-md text-sm px-3 py-2 font-medium text-gray-900 dark:text-gray-400 hover:bg-white/5 hover:text-blue-500 transition duration-400">Политика
                конфиденциальности</a>
        </div>
    </div>
</div>
