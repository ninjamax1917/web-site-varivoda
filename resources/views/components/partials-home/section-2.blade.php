@php
	use App\Services\ServiceList;
	$services = ServiceList::all();
@endphp

<section class="w-full py-12 md:py-16">
	<div class="container mx-auto px-4">
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
			<!-- Left: About company -->
			<div>
				<h2 class="text-3xl md:text-4xl font-bold mb-4">О компании</h2>
				<p class="text-base md:text-lg text-base-content/80 leading-relaxed mb-4">
					Мы проектируем, монтируем и сопровождаем инженерные системы: от
					электрики и сетей до видеонаблюдения и сигнализации. Работаем «под ключ»,
					соблюдаем сроки и стандарты безопасности. Выбирайте нужную услугу —
					перейдите по клику на кубе справа.
				</p>
				<ul class="list-disc list-inside text-base-content/80 space-y-1">
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

	<!-- Local styles for the cube (scoped to this section) -->
	<style>
		.cube-scene {
			--cube-size: 280px; /* базовый размер */
			perspective: 1000px;
			width: var(--cube-size);
			height: var(--cube-size);
		}

		@media (max-width: 640px) {
			.cube-scene {
				--cube-size: 220px;
			}
		}

		.cube {
			position: relative;
			width: 100%;
			height: 100%;
			transform-style: preserve-3d;
			will-change: transform;
			transition: transform .06s linear;
		}

		.cube-face {
			position: absolute;
			width: 100%;
			height: 100%;
			display: flex;
			align-items: center;
			justify-content: center;
			text-align: center;
			padding: 1rem;
			border: 1px solid hsl(var(--bc) / .25);
			background: linear-gradient(135deg, hsl(var(--b1)) 0%, hsl(var(--b2)) 100%);
			color: hsl(var(--bc));
			text-decoration: none;
			box-shadow: 0 10px 25px rgba(0,0,0,.15) inset, 0 6px 18px rgba(0,0,0,.08);
			backface-visibility: hidden;
			user-select: none;
		}

		.cube-face:hover .face-label {
			transform: scale(1.04);
		}

		.face-label {
			font-weight: 600;
			line-height: 1.2;
			transition: transform .15s ease;
		}

		/* Раскладка граней относительно половины размера куба */
		.face-front  { transform: translateZ(calc(var(--cube-size) / 2)); }
		.face-back   { transform: rotateY(180deg) translateZ(calc(var(--cube-size) / 2)); }
		.face-right  { transform: rotateY( 90deg) translateZ(calc(var(--cube-size) / 2)); }
		.face-left   { transform: rotateY(-90deg) translateZ(calc(var(--cube-size) / 2)); }
		.face-top    { transform: rotateX( 90deg) translateZ(calc(var(--cube-size) / 2)); }
		.face-bottom { transform: rotateX(-90deg) translateZ(calc(var(--cube-size) / 2)); }
	</style>

	<!-- Alpine component -->
	<script>
		function cube3d() {
			return {
				angleX: -15,
				angleY: 25,
				velX: 0,
				velY: 0,
				lastX: 0,
				lastY: 0,
				isDown: false,
				isDragging: false,
				dragMoved: false,
				rafId: null,
				autoSpin: 0.06, // авто-вращение вокруг Y

				get cubeStyle() {
					return `transform: rotateX(${this.angleX}deg) rotateY(${this.angleY}deg);`;
				},

				init() {
					const tick = () => {
						if (!this.isDown) {
							this.angleY += this.autoSpin;
						} else {
							// моментум при отпускании
							this.angleX += this.velX;
							this.angleY += this.velY;
							this.velX *= 0.95;
							this.velY *= 0.95;
							if (Math.abs(this.velX) < 0.001) this.velX = 0;
							if (Math.abs(this.velY) < 0.001) this.velY = 0;
						}
						this.rafId = requestAnimationFrame(tick);
					};
					this.rafId = requestAnimationFrame(tick);
				},

				onPointerDown(e) {
					this.isDown = true;
					this.dragMoved = false;
					this.isDragging = false;
					this.lastX = e.clientX;
					this.lastY = e.clientY;
				},

				onPointerMove(e) {
					if (!this.isDown) return;
					const dx = e.clientX - this.lastX;
					const dy = e.clientY - this.lastY;
					if (Math.abs(dx) > 2 || Math.abs(dy) > 2) {
						this.dragMoved = true;
						this.isDragging = true;
					}
					this.lastX = e.clientX;
					this.lastY = e.clientY;

					// чувствительность поворота
					const sens = 0.4;
					this.angleY += dx * sens;
					this.angleX -= dy * sens;

					// ограничим X, чтобы не переворачивался странно
					this.angleX = Math.max(-88, Math.min(88, this.angleX));

					// скорость для моментума
					this.velY = dx * 0.01;
					this.velX = -dy * 0.01;
				},

				onPointerUp() {
					this.isDown = false;
					// снимем флаг drag через небольшой таймаут, чтобы клики не прилипали
					setTimeout(() => { this.isDragging = false; }, 80);
				},

				handleClick(event) {
					// если был заметный drag — не кликаем
					if (this.dragMoved) return;
					// если не было drag — переходим по ссылке
					const a = event.currentTarget;
					if (a && a.href) {
						window.location.href = a.href;
					}
				}
			}
		}
	</script>
</section>
