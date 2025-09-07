// Компонент Alpine для интерактивного 3D‑куба
// Назначение: состояние поворота, авто‑вращение и перетаскивание указателем,
// с переходом по клику на грань (если не было перетаскивания).
// Контракт:
// - x-data="cube3d()" — инициализация компонента в разметке
// - геттер cubeStyle — возвращает CSS‑трансформацию для обёртки куба
// - onPointerDown/Move/Up — жизненный цикл перетаскивания; handleClick — навигация, если не было drag
// Примечания:
// - Автовращение останавливается при drag и возобновляется после отпускания
// - Угол по X ограничен, чтобы не переворачивать куб вверх дном (читабельность подписей)
export function cube3d() {
  return {
    angleX: -15,
    angleY: 25,
    // Скорости авто‑вращения (градусов за кадр).
    // Было после предыдущего шага: X=0.032, Y=0.096 (увеличение ×1.6)
    // Ещё раз ускоряем ×1.2: X=0.0384, Y=0.1152
    autoSpinX: 0.0384, // вертикальная компонента (вниз)
    autoSpinY: 0.1152, // горизонтальная компонента
    velX: 0,
    velY: 0,
    lastX: 0,
    lastY: 0,
  pointerType: 'mouse',
    isDown: false,
    isDragging: false,
    dragMoved: false,
    rafId: null,

    // Трансформация куба — минимум логики в шаблоне, всё в компоненте
    get cubeStyle() {
      return `transform: rotateX(${this.angleX}deg) rotateY(${this.angleY}deg);`;
    },

    init() {
      // Запускаем rAF‑цикл для авто‑вращения и инерции
    const scene = document.querySelector('.cube-scene');
      const tick = () => {
        if (!this.isDown) {
          // Автовращение, когда пользователь не тянет куб
          this.angleY += this.autoSpinY;
          this.angleX += this.autoSpinX;
        } else {
          // Во время перетаскивания — небольшая инерция по скорости указателя
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
      // Начало drag: захватываем указатель, сбрасываем флаги, запоминаем координаты
      this.isDown = true;
      try { e.target.setPointerCapture && e.target.setPointerCapture(e.pointerId); } catch (_) {}
      this.pointerType = e.pointerType || (e.touches ? 'touch' : 'mouse');
      this.dragMoved = false;
      this.isDragging = false;
      this.lastX = e.clientX;
      this.lastY = e.clientY;
  const scene = e.currentTarget.closest('.cube-scene');
  if (scene) scene.classList.add('dragging');
    },

    onPointerMove(e) {
      // Обновляем углы при перетаскивании; блокируем скролл (если можно отменить)
      if (!this.isDown) return;
      if (e.cancelable) e.preventDefault();
  const dx = e.clientX - this.lastX;
  const dy = e.clientY - this.lastY;
      // Порог, после которого считаем, что это drag, а не tap
  if (Math.abs(dx) > 5 || Math.abs(dy) > 5) {
        this.dragMoved = true;
        this.isDragging = true;
      }
      this.lastX = e.clientX;
      this.lastY = e.clientY;

      // Чувствительность: для touch вертикаль сильнее
  const isTouch = this.pointerType === 'touch' || this.pointerType === 'pen';
  const sensX = isTouch ? 0.6 : 0.5;  // horizontal
  const sensY = isTouch ? 1.35 : 0.75; // vertical
  this.angleY += dx * sensX;
  this.angleX -= dy * sensY;

      // Держим куб в читаемом диапазоне по X (не переворачиваем)
      this.angleX = Math.max(-88, Math.min(88, this.angleX));

      // Текущая «скорость» для лёгкой инерции
      this.velY = dx * 0.01;
      this.velX = -dy * 0.01;
    },

    onPointerUp(e) {
      // Конец drag: отпускаем захват, убираем класс, даём ссылкам сработать если не тянули
      this.isDown = false;
      try { e && e.target && e.target.releasePointerCapture && e.target.releasePointerCapture(e.pointerId); } catch (_) {}
      setTimeout(() => {
        this.isDragging = false;
      }, 80);
  const scene = document.querySelector('.cube-scene');
  if (scene) scene.classList.remove('dragging');
    },

    handleClick(event) {
      // Навигация только если не было перетаскивания
      if (this.dragMoved) return;
      const a = event.currentTarget;
      if (a && a.href) {
        window.location.href = a.href;
      }
    },
  };
}

// Регистрация в window, чтобы x-data мог найти cube3d()
if (typeof window !== 'undefined') {
  window.cube3d = cube3d;

  // Запрещаем контекстное меню по долгому тапу внутри сцены
  window.addEventListener('contextmenu', (e) => {
    if (e.target.closest('.cube-scene')) e.preventDefault();
  });
}
