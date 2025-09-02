const peerConnections = {};

function startWebRTC(index) {
    const video = document.getElementById(`video-modal-${index}`);
    const btn = document.getElementById(`open-modal-btn-${index}`);
    const streamPath = btn.getAttribute('data-stream-path');
    const streamUrl = `http://localhost:8889/${streamPath}/whep`;

    if (video) {
        try {
            const pc = new RTCPeerConnection();
            peerConnections[index] = pc;
            pc.ontrack = (event) => {
                video.srcObject = event.streams[0];
            };

            pc.createOffer({ offerToReceiveVideo: true }).then(offer => {
                pc.setLocalDescription(offer);
                return fetch(streamUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/sdp' },
                    body: offer.sdp
                });
            }).then(offerResp => offerResp.text())
              .then(answerSdp => pc.setRemoteDescription({ type: 'answer', sdp: answerSdp }))
              .catch(e => console.error('Ошибка WebRTC:', e));
        } catch (e) {
            console.error('Ошибка WebRTC:', e);
        }
    }
}

function stopWebRTC(index) {
    const video = document.getElementById(`video-modal-${index}`);
    if (video) {
        video.pause();
        video.srcObject = null;
    }
    if (peerConnections[index]) {
        peerConnections[index].close();
        delete peerConnections[index];
    }
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[id^="open-modal-btn-"]').forEach(openBtn => {
        const index = openBtn.id.replace('open-modal-btn-', '');
        const closeBtn = document.getElementById(`close-modal-btn-${index}`);
        const modal = document.getElementById(`modal-${index}`);

        if (openBtn && closeBtn && modal) {
            openBtn.addEventListener('click', (e) => {
                e.preventDefault();
                modal.classList.remove('hidden');
                startWebRTC(index);
            });

            closeBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
                stopWebRTC(index);
            });

            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    stopWebRTC(index);
                }
            });
        }
    });
});