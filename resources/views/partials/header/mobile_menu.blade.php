<div x-show="open" x-transition class="sm:hidden">
    <div class="space-y-1 px-2 pt-2 pb-3">
        <a href="#"
            class="text-center block rounded-md px-3 py-2 font-medium text-gray-900 hover:bg-white/5 hover:text-blue-500">Главная</a>

        <div x-data="{ subOpen: false }" class="relative">
            <button @click="subOpen = !subOpen"
                class="w-full text-center block rounded-md px-3 py-2 font-medium text-gray-900 hover:bg-white/5 hover:text-blue-500">
                Услуги
                <svg :class="{ 'rotate-180': subOpen }"
                    class="inline-block ml-1 h-4 w-4 transition-transform duration-300" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="subOpen" x-transition class="mt-1 space-y-1">
                @foreach ($services as $service)
                    <a href="#"
                        class="text-center block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-white/10 hover:text-blue-500">
                        {{ $service }}
                    </a>
                @endforeach
            </div>
        </div>

        <a href="#"
            class="text-center block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-white/5 hover:text-blue-500">Камеры
            города</a>
    </div>
</div>
