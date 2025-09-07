@php
    use App\Services\ServiceList;
    $services = ServiceList::all();
@endphp

<section class="w-full py-12 md:py-16 mt-0 md:mt-5 lg:mt-5">
    <div class="mx-auto w-full max-w-[1440px] px-4 sm:px-6 lg:px-8">
        <!-- Сетка из двух столбцов: текст и куб, строго по горизонтали -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
            <!-- Левый столбец: О компании -->
            <div class="text-gray-900 dark:text-inherit flex flex-col justify-start h-full">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 text-gray-900 dark:text-gray-100">О компании</h2>
                <p class="text-base md:text-lg leading-relaxed mb-4 text-gray-900/80 dark:text-gray-300">
    Мы проектируем, монтируем и сопровождаем инженерные системы: от
    объектов производственного назначения до частных домов. Работаем «под ключ»,
    соблюдаем сроки, нормы и правила, стандарты безопасности.
    <!-- Для десктопа -->
    <span class="hidden lg:block mt-5">
        Выбирайте нужную услугу, чтобы посмотреть примеры наших работ — перейдите по клику на кубе справа.
    </span>
    <!-- Для мобильных и планшетов -->
    <span class="inline lg:hidden">
        Выбирайте нужную услугу, чтобы посмотреть примеры наших работ — перейдите по клику на кубе снизу.
    </span>
</p>
                <ul class="list-disc list-inside text-gray-900/80 dark:text-gray-300 space-y-1">
                    <li>Проектирование и обследование объектов</li>
                    <li>Монтаж, пусконаладка и интеграция</li>
                    <li>Техническое обслуживание и поддержка</li>
                </ul>
            </div>

            <!-- Правый столбец: интерактивный куб -->
            <div x-data="cube3d()" x-init="init()"
                class="flex flex-col items-center justify-start h-full mt-8 md:mt-10 sm:mt-0">
                <!-- Сцена куба -->
                <div class="cube-scene select-none" @pointerdown="onPointerDown($event)"
                    @pointermove.window="onPointerMove($event)" @pointerup.window="onPointerUp()"
                    @pointercancel.window="onPointerUp()" aria-label="Интерактивный куб с услугами">
                    <!-- Сам куб -->
                    <div class="cube" :style="cubeStyle" @pointerdown.stop="onPointerDown($event)">
                        @foreach ($services as $idx => $service)
                            @php
                                // Позиции 6 граней: front, back, right, left, top, bottom
                                $faces = ['front', 'back', 'right', 'left', 'top', 'bottom'];
                                $face = $faces[$idx] ?? null;
                                $routeName = $service['slug'];
                            @endphp
                            @if ($face)
                                <!-- Грань‑ссылка на услугу -->
                                <a class="cube-face face-{{ $face }}" href="{{ route($routeName) }}"
                                    :class="{ 'pointer-events-none': isDragging }"
                                    @pointerdown.stop="onPointerDown($event)" @click.prevent="handleClick($event)"
                                    title="{{ $service['name'] }}">
                                    <span class="face-label">{{ $service['name'] }}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
                <!-- Подсказка ниже куба -->
                <div class="cube-drag-hint select-none text-gray-800 dark:text-gray-300 mt-23 sm:mt-23 md:mt-23">
                    <span class="text-xs sm:text-sm text-gray-800 dark:text-gray-300">Поверните куб</span>
                    <span
                        class="hint-360 flex items-center justify-center rounded-full border-1 border-[#51A2FF] text-base sm:text-lg md:text-xl font-bold bg-white dark:bg-[#232325] shadow"
                        aria-hidden="true">
                        360°
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>
