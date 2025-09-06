@php
	use App\Services\ServiceList;
	$services = ServiceList::all();
@endphp

<section class="w-full py-12 md:py-16">
	<div class="container mx-auto px-4">
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
			<!-- Left: About company -->
			<div class="text-gray-900 dark:text-inherit">
				<h2 class="text-3xl md:text-4xl font-bold mb-4 text-gray-900">О компании</h2>
				<p class="text-base md:text-lg leading-relaxed mb-4 text-gray-900/80 dark:text-gray-300">
					Мы проектируем, монтируем и сопровождаем инженерные системы: от
					электрики и сетей до видеонаблюдения и сигнализации. Работаем «под ключ»,
					соблюдаем сроки и стандарты безопасности. Выбирайте нужную услугу —
					перейдите по клику на кубе справа.
				</p>
				<ul class="list-disc list-inside text-gray-900/80 dark:text-gray-300 space-y-1">
					<li>Проектирование и обследование объектов</li>
					<li>Монтаж, пусконаладка и интеграция</li>
					<li>Сервисное обслуживание и поддержка</li>
				</ul>
			</div>

			<!-- Right: Interactive 3D Cube -->
			<div
				x-data="cube3d()"
				x-init="init()"
				class="flex justify-center"
			>
				<div
					class="cube-scene select-none"
					@pointerdown="onPointerDown($event)"
					@pointermove.window="onPointerMove($event)"
					@pointerup.window="onPointerUp()"
					@pointercancel.window="onPointerUp()"
					aria-label="Интерактивный куб с услугами"
				>
					<div class="cube" :style="cubeStyle">
						@foreach($services as $idx => $service)
							@php
								// Позиции 6 граней: front, back, right, left, top, bottom
								$faces = ['front', 'back', 'right', 'left', 'top', 'bottom'];
								$face = $faces[$idx] ?? null;
								$routeName = $service['slug'];
							@endphp
							@if($face)
								<a
									class="cube-face face-{{$face}}"
									href="{{ route($routeName) }}"
									:class="{ 'pointer-events-none': isDragging }"
									@click.prevent="handleClick($event)"
									title="{{ $service['name'] }}"
								>
									<span class="face-label">{{ $service['name'] }}</span>
								</a>
							@endif
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
