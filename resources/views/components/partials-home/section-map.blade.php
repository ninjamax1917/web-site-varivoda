<section id="map-info" class="w-full py-12 md:py-16">
    <div class="mx-auto w-full max-w-[1440px] px-4 sm:px-6 lg:px-8">
        <h2
            class="text-3xl md:text-4xl font-bold mb-4 text-gray-900 dark:text-gray-100 border-l-4 border-[#51A3FF] pl-3">
            Информация
        </h2>
        <h3 class="text-base md:text-lg font-normal leading-relaxed text-gray-700/90 dark:text-gray-300 mb-6 max-w-3xl">
            Адрес, контакты и реквизиты нашей компании. Постройте маршрут на Яндекс.Картах одним кликом.
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
            <!-- Левая колонка: Яндекс Карта -->
            <div>
                <div id="yandex-map"
                    class="w-full rounded-2xl overflow-hidden ring-1 ring-gray-200/70 dark:ring-white/10 bg-gray-50 dark:bg-[#1A1A1D]"
                    style="height: 420px"></div>
                <div class="mt-4">
                    <a id="build-route-btn" href="https://yandex.ru/maps/?rtext=~46.041782,38.182705&rtt=auto"
                        class="btn-glow inline-flex items-center gap-2 px-5 py-3 rounded-xl border border-[#51A3FF]/60 bg-white text-gray-900 dark:bg-[#232325] dark:text-gray-100 hover:border-[#51A3FF] shadow-sm hover:shadow focus:outline-none focus:ring-2 focus:ring-[#51A3FF] focus:ring-offset-2 dark:focus:ring-offset-[#18181B] transition"
                        title="Построить маршрут">
                        ПОСТРОИТЬ МАРШРУТ
                        <svg class="-mt-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-map-pinned-icon lucide-map-pinned">
                            <path
                                d="M18 8c0 3.613-3.869 7.429-5.393 8.795a1 1 0 0 1-1.214 0C9.87 15.429 6 11.613 6 8a6 6 0 0 1 12 0" />
                            <circle cx="12" cy="8" r="2" />
                            <path
                                d="M8.714 14h-3.71a1 1 0 0 0-.948.683l-2.004 6A1 1 0 0 0 3 22h18a1 1 0 0 0 .948-1.316l-2-6a1 1 0 0 0-.949-.684h-3.712" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Правая колонка: Информация и реквизиты -->
            <div class="prose dark:prose-invert max-w-none text-gray-900 dark:text-gray-200">
                <h3 class="mt-0">О компании:</h3>
                <p class="mb-3">Индивидуальный предприниматель<br />
                    <strong>Варивода Сергей Николаевич</strong>
                </p>

                <p class="mb-3">
                    <strong>Адрес осуществления предпринимательской деятельности</strong><br />
                    353865, Краснодарский край, Приморско-Ахтарский р-н, г. Приморско-Ахтарск, ул. Комсомольская, 66
                </p>

                <p class="mb-3">
                    <strong>Тел./факс:</strong> (8-861-43) 3-19-06<br />
                    <strong>E-mail:</strong> <a href="mailto:ip_varivoda@mail.ru">ip_varivoda@mail.ru</a>
                </p>

                <ul class="list-disc pl-5">
                    <li>Свидетельство 23 № 008152757 от 22.04.2011</li>
                    <li>ОГРН 311234711200032</li>
                    <li>ИНН 234701510918</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Подключение и инициализация Яндекс.Карт с поддержкой тёмной темы и построением маршрута -->
    <script defer
        src="https://api-maps.yandex.ru/2.1/?apikey=d36b5481-4624-40a6-8698-b0dd0c33d972&lang=ru_RU&load=package.full">
    </script>
    <script>
        (function initYandexMap() {
            const COMPANY_COORDS = [46.041782, 38.182705];
            const MAP_ELEMENT_ID = 'yandex-map';
            let mapInstance;
            let placeMarkInstance;
            let multiRouteInstance;

            function isDark() {
                // Tailwind dark class на html элементе
                return document.documentElement.classList.contains('dark');
            }

            function ensureDarkStyles() {
                // Применяем тёмный фильтр только к подложке карты внутри нашего контейнера
                const styleTagId = 'ymaps-dark-style-scoped';
                let styleTag = document.getElementById(styleTagId);
                if (!styleTag) {
                    styleTag = document.createElement('style');
                    styleTag.id = styleTagId;
                    document.head.appendChild(styleTag);
                }
                styleTag.textContent = `
                    html.dark #${MAP_ELEMENT_ID} .ymaps-2-1-79-ground-pane { filter: invert(90%) hue-rotate(180deg) brightness(90%) contrast(90%); }
                    html.dark #${MAP_ELEMENT_ID} .ymaps-2-1-79-copyrights-pane { filter: invert(90%) hue-rotate(180deg) brightness(90%) contrast(90%); }
                `;
            }

            function createMap() {
                if (!window.ymaps || !document.getElementById(MAP_ELEMENT_ID)) return;
                ymaps.ready(() => {
                    mapInstance = new ymaps.Map(MAP_ELEMENT_ID, {
                        center: COMPANY_COORDS,
                        zoom: 16,
                        controls: ['zoomControl', 'fullscreenControl'],
                    }, {
                        suppressMapOpenBlock: true,
                        yandexMapAutoSwitch: false,
                    });

                    placeMarkInstance = new ymaps.Placemark(COMPANY_COORDS, {
                        hintContent: 'ИП Варивода С.Н.',
                        balloonContent: 'ул. Комсомольская, 66, Приморско-Ахтарск',
                    }, {
                        // Дефолтный балун с синим маркером
                        preset: 'islands#blueIcon',
                    });

                    mapInstance.geoObjects.removeAll();
                    mapInstance.geoObjects.add(placeMarkInstance);

                    ensureDarkStyles();
                });
            }

            function updateTheme() {
                if (placeMarkInstance) {
                    placeMarkInstance.options.set('preset', 'islands#blueIcon');
                }
                ensureDarkStyles();
            }

            function onBuildRoute(event) {
                // Перенаправляем в Яндекс.Карты с автоматическим определением точки старта
                const fallbackHref =
                    `https://yandex.ru/maps/?rtext=~${COMPANY_COORDS[0]},${COMPANY_COORDS[1]}&rtt=auto`;
                try {
                    if (!navigator.geolocation) {
                        window.location.href = fallbackHref;
                        return;
                    }
                    if (event && event.preventDefault) event.preventDefault();
                    navigator.geolocation.getCurrentPosition((pos) => {
                        const lat = pos.coords.latitude.toFixed(6);
                        const lon = pos.coords.longitude.toFixed(6);
                        const url =
                            `https://yandex.ru/maps/?rtext=${lat},${lon}~${COMPANY_COORDS[0]},${COMPANY_COORDS[1]}&rtt=auto`;
                        window.location.href = url;
                    }, () => {
                        window.location.href = fallbackHref;
                    }, {
                        enableHighAccuracy: true,
                        timeout: 8000,
                        maximumAge: 0
                    });
                } catch (e) {
                    window.location.href = fallbackHref;
                }
            }

            function wireEvents() {
                const btn = document.getElementById('build-route-btn');
                if (btn) btn.addEventListener('click', onBuildRoute);
                // Отслеживаем переключение темы (если используется class dark на html и переключатель меняет класс)
                const observer = new MutationObserver((mutations) => {
                    for (const m of mutations) {
                        if (m.type === 'attributes' && m.attributeName === 'class') {
                            updateTheme();
                            break;
                        }
                    }
                });
                observer.observe(document.documentElement, {
                    attributes: true
                });
            }

            const boot = () => {
                if (!window.ymaps || !document.getElementById(MAP_ELEMENT_ID)) return;
                createMap();
                wireEvents();
            };

            if (document.readyState === 'complete' || document.readyState === 'interactive') {
                boot();
            } else {
                document.addEventListener('DOMContentLoaded', boot);
            }
        })();
    </script>
</section>
