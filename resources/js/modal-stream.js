const __bindModals = () => {
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

            // Close when clicking anywhere outside the content panel
            const content = modal.querySelector('[data-modal-content]');
            modal.addEventListener('click', (e) => {
                if (!content || !content.contains(e.target)) {
                    modal.classList.add('hidden');
                    (window.stopWebRTC || function(){ })(index);
                }
            });
            // Prevent inner clicks from closing (safety)
            if (content) content.addEventListener('click', (e) => e.stopPropagation());
            // Close on Escape
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
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
        // Close when clicking outside the auth content
        const authContent = modal.querySelector('[data-auth-modal-content]') || modal.querySelector('[role="dialog"]') || modal.firstElementChild;
        modal.addEventListener('click', (e) => {
            if (!authContent || !authContent.contains(e.target)) {
                modal.classList.add('hidden');
            }
        });
        modal.querySelectorAll('[data-close-auth]').forEach(close => {
            close.addEventListener('click', () => modal.classList.add('hidden'));
        });
    });
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', __bindModals, { once: true });
} else {
    __bindModals();
}