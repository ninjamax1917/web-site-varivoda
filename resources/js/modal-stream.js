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
});