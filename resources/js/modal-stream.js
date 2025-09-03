document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[id^="open-modal-btn-"]').forEach(openBtn => {
        const index = openBtn.id.replace('open-modal-btn-', '');
        const closeBtn = document.getElementById(`close-modal-btn-${index}`);
        const modal = document.getElementById(`modal-${index}`);

        if (openBtn && closeBtn && modal) {
            openBtn.addEventListener('click', (e) => {
                e.preventDefault();
                modal.classList.remove('hidden');
                (window.startWebRTC || function(){ })(index);
            });

            closeBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
                (window.stopWebRTC || function(){ })(index);
            });

            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    (window.stopWebRTC || function(){ })(index);
                }
            });
        }
    });

    // Гостям показываем модалку-требование авторизации
    document.querySelectorAll('[id^="open-auth-modal-btn-"]').forEach(btn => {
        const index = btn.id.replace('open-auth-modal-btn-', '');
        const modal = document.getElementById(`auth-required-modal-${index}`);
        if (!modal) return;
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            modal.classList.remove('hidden');
        });
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.classList.add('hidden');
        });
        modal.querySelectorAll('[data-close-auth]').forEach(close => {
            close.addEventListener('click', () => modal.classList.add('hidden'));
        });
    });
});