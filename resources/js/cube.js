// Alpine component for the interactive 3D cube
export function cube3d() {
  return {
    angleX: -15,
    angleY: 25,
  autoSpinX: 0.02, // slow vertical auto-rotation (downwards)
  autoSpinY: 0.06, // horizontal auto-rotation
    velX: 0,
    velY: 0,
    lastX: 0,
    lastY: 0,
  pointerType: 'mouse',
    isDown: false,
    isDragging: false,
    dragMoved: false,
    rafId: null,

    get cubeStyle() {
      return `transform: rotateX(${this.angleX}deg) rotateY(${this.angleY}deg);`;
    },

    init() {
      const scene = document.querySelector('.cube-scene');
      const tick = () => {
        if (!this.isDown) {
          this.angleY += this.autoSpinY;
          this.angleX += this.autoSpinX;
        } else {
          // momentum
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
      if (!this.isDown) return;
      if (e.cancelable) e.preventDefault();
  const dx = e.clientX - this.lastX;
  const dy = e.clientY - this.lastY;
  // slightly lower threshold so drag starts easier on mobile
  if (Math.abs(dx) > 5 || Math.abs(dy) > 5) {
        this.dragMoved = true;
        this.isDragging = true;
      }
      this.lastX = e.clientX;
      this.lastY = e.clientY;

  // Sensitivity: stronger vertical for touch
  const isTouch = this.pointerType === 'touch' || this.pointerType === 'pen';
  const sensX = isTouch ? 0.6 : 0.5;  // horizontal
  const sensY = isTouch ? 1.35 : 0.75; // vertical
  this.angleY += dx * sensX;
  this.angleX -= dy * sensY;

      this.angleX = Math.max(-88, Math.min(88, this.angleX));

      this.velY = dx * 0.01;
      this.velX = -dy * 0.01;
    },

    onPointerUp(e) {
  this.isDown = false;
      try { e && e.target && e.target.releasePointerCapture && e.target.releasePointerCapture(e.pointerId); } catch (_) {}
      setTimeout(() => {
        this.isDragging = false;
      }, 80);
  const scene = document.querySelector('.cube-scene');
  if (scene) scene.classList.remove('dragging');
    },

    handleClick(event) {
      if (this.dragMoved) return;
      const a = event.currentTarget;
      if (a && a.href) {
        window.location.href = a.href;
      }
    },
  };
}

// Auto-register on window for inline x-data references
if (typeof window !== 'undefined') {
  window.cube3d = cube3d;

  // Prevent long-press context menu and text selection on cube faces (mobile)
  window.addEventListener('contextmenu', (e) => {
    if (e.target.closest('.cube-scene')) e.preventDefault();
  });
}
