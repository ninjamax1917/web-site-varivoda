@php
    use App\Services\ServiceList;
    $services = ServiceList::all();
@endphp

<section class="w-full py-12 md:py-16 mt-0 md:mt-5 lg:mt-5">
    <div class="mx-auto w-full max-w-[1440px] px-4 sm:px-6 lg:px-8">
        <!-- Сетка из двух столбцов: текст и кнопки услуг, строго по горизонтали -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start lg:items-stretch">
            <!-- Левый столбец: О компании -->
            <div class="text-gray-900 dark:text-inherit flex flex-col justify-start h-full lg:col-span-2">
                <h2
                    class="text-3xl md:text-4xl font-bold mb-4 text-gray-900 dark:text-gray-100 border-l-4 border-[#51A3FF] pl-3">
                    О компании</h2>
                <p class="text-base md:text-lg leading-relaxed mb-5 text-gray-900/80 dark:text-gray-300">
                    Наша команда проектирует, устанавливает и обслуживает инженерные системы любой сложности — от
                    промышленных объектов до загородных домов. Мы работаем «под ключ», гарантируя соблюдение сроков,
                    стандартов безопасности и качества.
                </p>

                <h3 class="text-lg md:text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Почему выбирают нас:
                </h3>
                <ul
                    class="list-none grid grid-cols-1 lg:grid-cols-2 gap-x-3 gap-y-2 text-gray-900/80 dark:text-gray-300 mb-5">
                    <li
                        class="relative pl-4 before:content-['•'] before:absolute before:left-0 before:text-[#51A3FF] before:top-0.5">
                        Более 15 лет опыта в отрасли</li>
                    <li
                        class="relative pl-4 before:content-['•'] before:absolute before:left-0 before:text-[#51A3FF] before:top-0.5">
                        Сертифицированные инженеры</li>
                    <li
                        class="relative pl-4 before:content-['•'] before:absolute before:left-0 before:text-[#51A3FF] before:top-0.5">
                        Собственное проектное бюро</li>
                    <li
                        class="relative pl-4 before:content-['•'] before:absolute before:left-0 before:text-[#51A3FF] before:top-0.5">
                        Прозрачное ценообразование</li>
                    <li
                        class="relative pl-4 before:content-['•'] before:absolute before:left-0 before:text-[#51A3FF] before:top-0.5">
                        Гарантия на все работы</li>
                </ul>

                <h3 class="text-lg md:text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Наши услуги:</h3>
                <ul class="space-y-3 mb-5">
                    <li class="text-gray-900/90 dark:text-gray-200">
                        <span class="font-medium">Проектирование и обследование объектов</span>
                        <span class="block text-sm text-gray-700 dark:text-gray-300">— Анализ, разработка, согласование
                            документации</span>
                    </li>
                    <li class="text-gray-900/90 dark:text-gray-200">
                        <span class="font-medium">Монтаж, пусконаладка и интеграция</span>
                        <span class="block text-sm text-gray-700 dark:text-gray-300">— Установка, запуск, интеграция в
                            существующую инфраструктуру</span>
                    </li>
                    <li class="text-gray-900/90 dark:text-gray-200">
                        <span class="font-medium">Техническое обслуживание и поддержка</span>
                        <span class="block text-sm text-gray-700 dark:text-gray-300">— Сервисное сопровождение,
                            профилактика, оперативная помощь</span>
                    </li>
                </ul>


            </div>

            <!-- Правый столбец: кнопки услуг -->
            <div
                class="flex flex-col items-start justify-start lg:justify-center h-full mt-2 md:mt-4 lg:mt-0 lg:border-l lg:border-slate-300 dark:lg:border-white/10 lg:pl-8 lg:col-span-1">
                <p class="mb-3 text-base md:text-lg font-medium text-gray-900/80 dark:text-gray-200">
                    Посмотрите примеры наших работ
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-3 md:gap-4 w-full">
                    @foreach ($services as $service)
                        @php
                            $routeName = $service['slug'];
                        @endphp
                        <a href="{{ route($routeName) }}"
                            class="btn-glow relative z-0 group inline-flex items-center justify-between w-full rounded-xl border border-[#51A3FF]/60 bg-white text-gray-900 dark:bg-[#232325] dark:text-gray-100 hover:border-[#51A3FF] px-4 py-3 leading-tight min-h-[52px] md:min-h-[56px] h-full shadow-sm hover:shadow transition focus:outline-none focus:ring-2 focus:ring-[#51A3FF] focus:ring-offset-2 dark:focus:ring-offset-[#18181B]"
                            title="{{ $service['name'] }}" aria-label="Услуга: {{ $service['name'] }}">
                            <span class="relative z-10 font-semibold">{{ $service['name'] }}</span>
                            <span
                                class="relative z-10 ml-3 text-[#1E40AF] dark:text-[#DCEBFF] opacity-70 group-hover:opacity-100 transition-transform group-hover:translate-x-0.5"
                                aria-hidden="true">→</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
