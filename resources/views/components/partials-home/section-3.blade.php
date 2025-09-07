@php
	$dir = public_path('images/certificates');
	$slides = [];
	if (is_dir($dir)) {
		$all = \Illuminate\Support\Facades\File::files($dir);
		$byStem = [];
		foreach ($all as $file) {
			$ext = strtolower($file->getExtension());
			$stem = pathinfo($file->getFilename(), PATHINFO_FILENAME);
			if (! isset($byStem[$stem])) {
				$byStem[$stem] = [];
			}
			$byStem[$stem][$ext] = $file->getFilename();
		}

		$imageExts = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];
		foreach ($byStem as $stem => $parts) {
			$imageFile = null;
			foreach ($imageExts as $ie) {
				if (isset($parts[$ie])) {
					$imageFile = $parts[$ie];
					break;
				}
			}
			if ($imageFile) {
				$pdfFile = $parts['pdf'] ?? null;
				$slides[] = [
					'image' => asset('images/certificates/'.$imageFile),
					'pdf' => $pdfFile ? asset('images/certificates/'.$pdfFile) : '#',
					'alt' => $stem,
				];
			}
		}

		// sort by filename for stable order
		usort($slides, fn($a, $b) => strcmp($a['alt'], $b['alt']));
	}
@endphp

<section id="certificates" class="py-10 md:py-14">
	<div class="container mx-auto px-4">
		<h2 class="text-2xl md:text-3xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
			Лицензии и сертификаты
		</h2>

		@if (empty($slides))
			<p class="text-gray-600 dark:text-gray-300">Сертификаты не найдены. Поместите файлы в public/images/certificates/</p>
		@else
			<div class="swiper" data-swiper-options='{"slidesPerView":1,"spaceBetween":16,"breakpoints":{"640":{"slidesPerView":2,"spaceBetween":16},"1024":{"slidesPerView":3,"spaceBetween":24}},"loop":true}'>
				<div class="swiper-wrapper">
					@foreach ($slides as $s)
						<div class="swiper-slide">
							<a href="{{ $s['pdf'] }}" target="_blank" rel="noopener" class="block group">
								<div class="aspect-[3/4] w-full overflow-hidden rounded-lg bg-gray-100 dark:bg-[#1f1f21] ring-1 ring-gray-200/60 dark:ring-white/10">
									<img src="{{ $s['image'] }}" alt="{{ $s['alt'] }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-[1.02]" loading="lazy" />
								</div>
								<div class="mt-3 text-sm text-gray-700 dark:text-gray-300 truncate group-hover:text-primary">
									{{ \Illuminate\Support\Str::of($s['alt'])->replace('_',' ')->replace('-',' ')->title() }}
								</div>
							</a>
						</div>
					@endforeach
				</div>
				<div class="swiper-pagination"></div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
		@endif
	</div>
</section>

