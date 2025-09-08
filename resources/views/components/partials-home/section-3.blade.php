@php
	use Illuminate\Support\Facades\File;
	use Illuminate\Support\Facades\URL as URLFacade;

	$dir = public_path('images/certificates');
	$files = File::exists($dir) ? File::files($dir) : [];
	$items = [];

	$normalizeKey = function (string $base) {
		// Убираем суффикс вида: "page 1", "page-1", "page_1" в конце имени
		$clean = preg_replace('/([_\-\s])*page([_\-\s])*\d+$/i', '', $base);
		// Нормализуем для ключа
		$norm = strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($clean)));
		$norm = trim($norm, '-');
		return [$norm, $clean];
	};

	foreach ($files as $f) {
		$ext = strtolower($f->getExtension());
		if (!in_array($ext, ['jpg', 'jpeg', 'png', 'pdf'])) {
			continue;
		}
		$raw = pathinfo($f->getFilename(), PATHINFO_FILENAME);
		[$key, $cleanTitle] = $normalizeKey($raw);
		$url = asset('images/certificates/' . $f->getFilename());

		if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
			// Превью изображение (может быть вида "Name page 1.jpg")
			$items[$key]['image'] = $url;
		} elseif ($ext === 'pdf') {
			// Основной файл
			$items[$key]['pdf'] = $url;
		}

		// Человекочитаемый заголовок на основе чистого имени
		if (!isset($items[$key]['title'])) {
			$items[$key]['title'] = ucfirst(str_replace(['_', '-'], ' ', $cleanTitle));
		}
	}

	ksort($items);
@endphp

<section class="w-full py-12 md:py-16">
	<div class="mx-auto w-full max-w-[1440px] px-4 sm:px-6 lg:px-8">
		<h2 class="text-2xl md:text-3xl font-bold mb-6 text-gray-900 dark:text-gray-100">Сертификаты и лицензии</h2>

		<div class="swiper w-full"
			data-swiper-options='{
				"slidesPerView": 1,
				"spaceBetween": 20,
				"breakpoints": {
					"640": { "slidesPerView": 1 },
					"768": { "slidesPerView": 2 },
					"1024": { "slidesPerView": 3 },
					"1280": { "slidesPerView": 4 }
				},
				"loop": false
			}'>
			<div class="swiper-wrapper items-stretch">
				@foreach ($items as $key => $it)
					@php
						$hasPdf = isset($it['pdf']);
						// Поддерживаем разные варианты написания: project/proekt, montaj/montazh
						$specialKeys = ['project', 'proekt', 'montaj', 'montazh'];
						$isSpecial = in_array(strtolower($key), $specialKeys, true);
						$link = $hasPdf
							? URLFacade::temporarySignedRoute('certificates.show', now()->addMinutes(15), ['key' => $key])
							: ($isSpecial
								? 'https://mchs.gov.ru/'
								: ($it['image'] ?? '#'));
					@endphp
					<div class="swiper-slide">
						<a href="{{ $link }}" target="_blank" rel="noopener" class="block group h-full">
							<div class="card bg-gray-200/70 dark:bg-[#232325]/50 w-full h-[500px] sm:h-[520px] md:h-[560px] lg:h-[560px] shadow-lg overflow-hidden flex flex-col">
								<div class="w-full flex-1 min-h-0 bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
									@if (!empty($it['image']))
										<img src="{{ $it['image'] }}" alt="{{ $it['title'] }}"
								class="w-full h-full object-cover rounded-none"
											 loading="lazy">
									@else
										<div class="flex flex-col items-center justify-center text-gray-600 dark:text-gray-300">
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-12 h-12 mb-2 fill-current"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zm0 2l6 6h-6zM8 13h8v2H8zm0 4h8v2H8zm0-8h4v2H8z"/></svg>
											<span class="text-sm font-medium">PDF</span>
										</div>
									@endif
								</div>
								<div class="flex items-center justify-center h-20 px-3">
									<h3 class="text-base md:text-lg text-center text-gray-800 dark:text-gray-100 truncate w-full">
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
</section>

