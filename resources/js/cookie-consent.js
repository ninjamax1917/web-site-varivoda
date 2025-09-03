function setCookie(name, value, days) {
    let expires = '';
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = '; expires=' + date.toUTCString();
    }
    document.cookie = name + '=' + (value || '') + expires + '; path=/; SameSite=Lax';
}

function eraseCookie(name) {
    document.cookie = name + '=; Max-Age=-99999999; path=/';
}

function showBanner() {
    const el = document.getElementById('cookie-consent');
    if (!el) return;
    el.classList.remove('hidden');
}

function hideBanner() {
    const el = document.getElementById('cookie-consent');
    if (!el) return;
    el.classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', () => {
    try {
        const consent = localStorage.getItem('cookie_consent');
        if (!consent) {
            showBanner();
        }

        const allowBtn = document.getElementById('allow-cookies');
        const disableBtn = document.getElementById('disable-cookies');

        if (allowBtn) {
            allowBtn.addEventListener('click', () => {
                localStorage.setItem('cookie_consent', 'allow');
                // set minimal cookie to mark consent
                setCookie('cookie_consent', 'allow', 365);
                hideBanner();
            });
        }

        if (disableBtn) {
            disableBtn.addEventListener('click', () => {
                localStorage.setItem('cookie_consent', 'deny');
                // send to server to destroy session cookie
                try {
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    fetch('/cookies/disable', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ disable: true })
                    }).catch(() => {});
                } catch (e) {}

                // erase common analytics cookies (client-side)
                eraseCookie('_ga');
                eraseCookie('_gid');
                eraseCookie('_gat');
                eraseCookie('cookie_consent');
                hideBanner();
            });
        }
    } catch (e) {
        // no-op
    }
});

export {};
