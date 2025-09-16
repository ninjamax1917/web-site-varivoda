(() => {
    function spinSelectArrow(selectEl) {
        if (!selectEl) return;
        const wrapper = selectEl.closest('.select-with-arrow');
        if (!wrapper) return;
        const arrow = wrapper.querySelector('.select-arrow');
        if (!arrow) return;
        // Trigger spin
        arrow.style.transition = 'transform 500ms ease-out';
        arrow.style.transform = 'rotate(540deg)';
        // Reset after animation so it can spin again next time without reverse
        const resetAfter = () => {
            arrow.style.transition = 'none';
            arrow.style.transform = 'none';
            // force reflow to apply the reset instantly
            // eslint-disable-next-line no-unused-expressions
            arrow.offsetHeight;
            arrow.style.transition = '';
        };
        setTimeout(resetAfter, 520);
    }

    function bindSelectArrowSpinners(root = document) {
        const wrappers = root.querySelectorAll('.select-with-arrow select');
        wrappers.forEach(sel => {
            if (sel.dataset.arrowSpinBound) return;
            sel.dataset.arrowSpinBound = '1';
            sel.addEventListener('mousedown', () => spinSelectArrow(sel));
            sel.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ' || e.key === 'Spacebar' || e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                    spinSelectArrow(sel);
                }
            });
        });
    }

    function animateResultReveal(el) {
        if (!el) return;
        el.style.opacity = '0';
        el.style.transform = 'translateY(8px)';
        el.style.transition = 'opacity 400ms ease, transform 400ms ease';
        requestAnimationFrame(() => {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
            setTimeout(() => {
                el.style.removeProperty('opacity');
                el.style.removeProperty('transform');
                el.style.removeProperty('transition');
            }, 450);
        });
    }

    function animateSwap(showEl, hideEl) {
        if (!showEl || !hideEl) return;
        // Prepare absolute overlay behavior
        [showEl, hideEl].forEach(el => {
            el.style.position = 'absolute';
            el.style.left = '0';
            el.style.top = '0';
            el.style.width = '100%';
        });
        // Fade out hideEl
        hideEl.style.opacity = '1';
        hideEl.style.transition = 'opacity 200ms ease';
        requestAnimationFrame(() => {
            hideEl.style.opacity = '0';
            setTimeout(() => { hideEl.style.display = 'none'; }, 200);
        });
        // Fade in showEl
        showEl.style.display = 'block';
        showEl.style.opacity = '0';
        showEl.style.transition = 'opacity 200ms ease';
        requestAnimationFrame(() => {
            showEl.style.opacity = '1';
        });
    }

    function toggleFields() {
        var methodEl = document.getElementById("method");
        var voltageEl = document.getElementById("voltage");
        if (!methodEl || !voltageEl) return;

        var method = methodEl.value;
        var voltageType = voltageEl.value;
        var isDC = voltageType === "VOLTAGE_DC";

        var currentFields = document.getElementById("current-fields");
        var powerFields = document.getElementById("power-fields");
        if (currentFields && powerFields) {
            // Ensure both exist in DOM flow, but overlay; container height is stabilized separately
            if (method === 'current') {
                animateSwap(currentFields, powerFields);
            } else {
                animateSwap(powerFields, currentFields);
            }
        } else {
            if (currentFields) currentFields.style.display = method === "current" ? "block" : "none";
            if (powerFields) powerFields.style.display = method === "power" ? "block" : "none";
        }

        var cosifiInput = document.querySelector('#power-fields [name="cosifi"]');
        if (cosifiInput) {
            var cosifiLabel = cosifiInput.closest("label");
            if (cosifiLabel) {
                cosifiLabel.style.display = isDC ? "none" : (method === "power" ? "block" : "none");
            }
        }

        stabilizeMethodContainer();
    }

    function measureEl(el) {
        if (!el) return 0;
        var prev = { display: el.style.display, position: el.style.position, visibility: el.style.visibility, height: el.style.height };
        var needShow = getComputedStyle(el).display === 'none';
        if (needShow) {
            el.style.visibility = 'hidden';
            el.style.display = 'block';
            el.style.position = 'absolute';
        }
        var h = el.scrollHeight;
        if (needShow) {
            el.style.display = prev.display;
            el.style.position = prev.position;
            el.style.visibility = prev.visibility;
            el.style.height = prev.height;
        }
        return h;
    }

    function stabilizeMethodContainer() {
        var container = document.getElementById('method-fields');
        if (!container) return;
        var cf = document.getElementById('current-fields');
        var pf = document.getElementById('power-fields');
        // Temporarily reset absolute positioning to measure natural heights
        [cf, pf].forEach(el => { if (el) { el.style.position = ''; el.style.display = 'block'; el.style.opacity = '1'; } });
        var maxH = Math.max(measureEl(cf), measureEl(pf));
        // Restore absolute for overlay behavior
        [cf, pf].forEach(el => { if (el) { el.style.position = 'absolute'; } });
        if (maxH > 0) {
            container.style.transition = container.style.transition || 'min-height 200ms ease';
            container.style.minHeight = maxH + 'px';
        }
    }

    function setDefaultVoltage(force = false) {
        var voltageEl = document.getElementById("voltage");
        var voltageValueField = document.getElementById("voltageValue");
        if (!voltageEl || !voltageValueField) return;
        if (force || !voltageValueField.value) {
            var voltageType = voltageEl.value;
            voltageValueField.value = voltageType === "VOLTAGE_AC_220" ? 220 : (voltageType === "VOLTAGE_AC_380" ? 380 : 12);
        }
    }

    function submitForm(event) {
        event.preventDefault();
        var form = document.getElementById("calcForm");
        if (!form) return;
        var formData = new FormData(form);

        fetch(form.action || "", {
            method: "POST",
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html,application/xhtml+xml'
            },
            body: formData
        })
            .then((response) => response.text())
            .then((html) => {
                var parser = new DOMParser();
                var doc = parser.parseFromString(html, "text/html");
                var newForm = doc.getElementById("calcForm");
                if (!newForm) return;
                // Анимация плавного появления результатов, если есть (we'll re-query after replace)

                form.replaceWith(newForm);
                // После замены формы — заново привяжем обработчики и обновим состояние/стили
                try {
                    toggleFields();
                    setDefaultVoltage();
                    stabilizeMethodContainer();
                    bindSelectArrowSpinners();
                    var cf2 = document.getElementById('current-fields');
                    var pf2 = document.getElementById('power-fields');
                    if (cf2 && pf2) {
                        [cf2, pf2].forEach(el => { el.style.position = 'absolute'; el.style.left = '0'; el.style.top = '0'; el.style.width = '100%'; });
                        if (document.getElementById('method')?.value === 'current') {
                            cf2.style.display = 'block'; pf2.style.display = 'none';
                        } else {
                            pf2.style.display = 'block'; cf2.style.display = 'none';
                        }
                    }
                    const liveResult = document.querySelector('#result-block .result');
                    if (liveResult) animateResultReveal(liveResult);
                } catch (e) { }
            })
            .catch(() => {
                var resultEl = document.getElementById("result-block");
                if (resultEl) {
                    resultEl.innerHTML = '<div class="result" style="color:red;">Ошибка запроса</div>';
                }
            });
    }

    document.addEventListener('DOMContentLoaded', () => {
        try {
            toggleFields();
            setDefaultVoltage();

            var form = document.getElementById('calcForm');
            if (form) form.addEventListener('submit', submitForm);

            var methodEl = document.getElementById('method');
            if (methodEl) methodEl.addEventListener('change', toggleFields);

            var voltageEl = document.getElementById('voltage');
            if (voltageEl) voltageEl.addEventListener('change', function () {
                toggleFields();
                setDefaultVoltage(true);
            });

            stabilizeMethodContainer();
            bindSelectArrowSpinners();
            // Ensure initial panel visibility states for overlay
            var cf = document.getElementById('current-fields');
            var pf = document.getElementById('power-fields');
            if (cf && pf) {
                cf.style.display = (document.getElementById('method')?.value === 'current') ? 'block' : 'none';
                pf.style.display = (document.getElementById('method')?.value === 'power') ? 'block' : 'none';
                [cf, pf].forEach(el => { el.style.position = 'absolute'; el.style.left = '0'; el.style.top = '0'; el.style.width = '100%'; });
            }
            window.addEventListener('resize', stabilizeMethodContainer);

            // Animate existing result on first render if present
            const initialResult = document.querySelector('#result-block .result');
            if (initialResult) animateResultReveal(initialResult);
        } catch (e) { /* noop */ }
    });

    // Экспортируем функции в глобальную область, чтобы работали inline-обработчики
    Object.assign(window, { toggleFields, setDefaultVoltage, submitForm });
})();