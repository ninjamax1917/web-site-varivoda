@php use Illuminate\Support\Facades\URL as URLFacade; @endphp

<section class="w-full py-12 md:py-16">
    <div class="mx-auto w-full max-w-[1440px] px-4 sm:px-6 lg:px-8">
        <hh2
            class="text-3xl md:text-4xl font-bold mb-4 text-gray-900 dark:text-gray-100 border-l-4 border-[#51A3FF] pl-3">
            Наши компетенции
            </h2>
            <h3
                class="text-base sm:text-sm md:text-md font-normal leading-relaxed text-gray-700/90 dark:text-gray-300 mb-6 max-w-3xl mt-5">
                Ознакомьтесь с нашими лицензиями и сертификатами, которые гарантируют высокий уровень наших услуг и
                квалификацию сотрудников
            </h3>

            <div
                class="rounded-2xl bg-gradient-to-b from-[#F8FBFF] to-white dark:from-[#1A1A1D] dark:to-[#141416] ring-1 ring-gray-200/70 dark:ring-white/10 p-3 sm:p-4 mt-10">
                <div class="swiper w-full cert-swiper" data-swiper-key="certificates">
                    <div class="swiper-wrapper items-stretch">
                        @foreach ($certificates ?? [] as $key => $it)
                            @php
                                $hasPdf = isset($it['pdf']);
                                $title = trim($it['title'] ?? '');
                                // Поддерживаем разные варианты написания: project/proekt, montaj/montazh
                                $specialKeys = ['project', 'proekt', 'montaj', 'montazh'];
                                $isSpecial = in_array(strtolower($key), $specialKeys, true);
                                // Точное соответствие для ссылок МЧС по заголовку
                                $mchsMap = [
                                    'разрешение на производство работ по проектированию мчс' =>
                                        'https://digital.mchs.gov.ru/fgpn/cert/project/Т002-00101-23/00650390',
                                    'разрешение на производство работ мчс' =>
                                        'https://digital.mchs.gov.ru/fgpn/cert/project/Т002-00101-52/01952507',
                                ];
                                $normTitle = function_exists('mb_strtolower')
                                    ? mb_strtolower($title, 'UTF-8')
                                    : strtolower($title);
                                $isMchsWeb = array_key_exists($normTitle, $mchsMap);
                                $link = '#';
                                if ($hasPdf) {
                                    $link = URLFacade::temporarySignedRoute(
                                        'certificates.show',
                                        now()->addMinutes(15),
                                        [
                                            'key' => $key,
                                        ],
                                    );
                                } elseif ($isMchsWeb) {
                                    $link = $mchsMap[$normTitle];
                                } elseif ($isSpecial) {
                                    $link = 'https://mchs.gov.ru/';
                                } elseif (!empty($it['image'])) {
                                    $link = $it['image'];
                                }
                            @endphp
                            <div class="swiper-slide">
                                <a href="{{ $link }}" target="_blank" rel="noopener" class="block group h-full">
                                    <div
                                        class="card border border-gray-300 dark:border-gray-900/50 bg-gray-200/70 dark:bg-[#232325]/50 w-full h-[500px] sm:h-[520px] md:h-[560px] lg:h-[560px] shadow-lg overflow-hidden flex flex-col transition-transform duration-200 group-hover:-translate-y-1 group-hover:shadow-xl">
                                        <div
                                            class="w-full flex-1 min-h-0 bg-gray-100 dark:bg-gray-800 flex items-center justify-center relative">
                                            @if ($hasPdf)
                                                <span
                                                    class="absolute top-2 right-2 z-10 inline-flex items-center px-2 py-0.5 rounded-md text-[10px] sm:text-xs font-semibold bg-[#51A2FF] text-white shadow">PDF</span>
                                            @elseif ($isMchsWeb || $isSpecial || (!$hasPdf && !empty($it['image'])))
                                                <span
                                                    class="absolute top-2 right-2 z-10 inline-flex items-center px-2 py-0.5 rounded-md text-[10px] sm:text-xs font-semibold bg-emerald-500 text-white shadow">WEB</span>
                                            @endif
                                            @if (!empty($it['image']))
                                                <img src="{{ $it['image'] }}" alt="{{ $it['title'] }}"
                                                    class="w-full h-full object-cover rounded-none" loading="lazy">
                                            @else
                                                <div
                                                    class="flex flex-col items-center justify-center text-gray-600 dark:text-gray-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        class="w-12 h-12 mb-2 fill-current">
                                                        <path
                                                            d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zm0 2l6 6h-6zM8 13h8v2H8zm0 4h8v2H8zm0-8h4v2H8z" />
                                                    </svg>
                                                    <span class="text-sm font-medium">PDF</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex items-center justify-center h-20 px-3">
                                            <h3 class="text-base md:text-lg text-center text-gray-800 dark:text-gray-100 w-full line-clamp-2"
                                                title="{{ $it['title'] }}">
                                                {{ $it['title'] }}
                                            </h3>
                                        </div>
                                    </div>
                                </a>
                                {{-- Доп. подписи убраны ради одинаковой высоты карточек --}}
                            </div>
                        @endforeach
                    </div>

                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
    </div>
</section>
