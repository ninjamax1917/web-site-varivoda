<div class="hidden md:ml-15 md:flex items-center w-full">
    <div class="flex space-x-4 flex-shrink-0">
        <a href="{{ route('home') }}" aria-current="page"
            class="rounded-md px-3 py-2 text-base font-medium text-gray-800 dark:text-[#A2A2A2] hover:text-blue-800 dark:hover:text-blue-500 transition duration-600">Главная</a>

        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="rounded-md px-3 py-2 text-base font-medium text-gray-800 dark:text-[#A2A2A2] hover:text-blue-800 dark:hover:text-blue-500 flex items-center cursor-pointer transition duration-600">
                Услуги
                <svg :class="{
                    'transform transition-transform duration-500 rotate-540': open,
                    'transform transition-transform duration-500': !open
                }"
                    class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="open" @click.away="open = false" x-cloak
                class="absolute left-0 mt-2 w-80 rounded-md shadow-lg bg-white dark:bg-[#232325] border border-gray-300 dark:border-gray-600 z-50 overflow-hidden"
                x-transition>
                @isset($services)
                    @foreach ($services as $service)
                        <x-partials.header.service-menu-item :href="route('service.show', $service['slug'])" :icon="$service['icon']">
                            {{ $service['name'] }}
                        </x-partials.header.service-menu-item>
                    @endforeach
                @endisset
            </div>
        </div>

        <a href="{{ route('cctv-city.index') }}"
            class="rounded-md px-3 py-2 text-base font-medium text-gray-800 dark:text-[#A2A2A2] hover:text-blue-800 dark:hover:text-blue-500 transition duration-600">Камеры
            города</a>

        <a href="{{ route('news.index') }}"
            class="rounded-md px-3 py-2 text-base font-medium text-gray-800 dark:text-[#A2A2A2] hover:text-blue-800 dark:hover:text-blue-500 transition duration-600">Новости</a>
    </div>
</div>
