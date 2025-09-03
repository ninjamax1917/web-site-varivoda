const peerConnections = {};
const hlsPlayers = {}; // index -> Hls instance

function startWebRTC(index) {
    const video = document.getElementById(`video-modal-${index}`);
    const btn = document.getElementById(`open-modal-btn-${index}`);
    const streamPath = btn.getAttribute('data-stream-path');
    const streamUrl = btn.getAttribute('data-whep') || `http://localhost:8889/${streamPath}/whep`;
    const hlsUrl = btn.getAttribute('data-hls');

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
                        }).then(offerResp => {
                                if (!offerResp.ok) throw new Error('WHEP HTTP ' + offerResp.status);
                                return offerResp.text();
                        }).then(answerSdp => pc.setRemoteDescription({ type: 'answer', sdp: answerSdp }))
                            .catch(e => {
                                    console.warn('WebRTC не удалось, пробуем HLS:', e);
                                    if (hlsUrl) tryHls(video, hlsUrl);
                            });
        } catch (e) {
                        console.warn('Ошибка WebRTC, пробуем HLS:', e);
                        if (hlsUrl) tryHls(video, hlsUrl);
        }
    }
}

function stopWebRTC(index) {
    const video = document.getElementById(`video-modal-${index}`);
    if (video) {
        video.pause();
        video.srcObject = null;
        // Остановим hls.js, если использовался
        if (hlsPlayers[index]) {
            try { hlsPlayers[index].destroy(); } catch (_) {}
            delete hlsPlayers[index];
            video.removeAttribute('src');
            video.load();
        }
    }
    if (peerConnections[index]) {
        peerConnections[index].close();
        delete peerConnections[index];
    }
}

function tryHls(video, src) {
    const canNative = video.canPlayType('application/vnd.apple.mpegurl');
    if (canNative) {
        video.src = src;
        video.play().catch(() => {});
        return;
    }
    if (window.Hls) {
        const hls = new Hls({ maxLiveSyncPlaybackRate: 1.0 });
        hls.loadSource(src);
        hls.attachMedia(video);
        // Сохраним для последующей остановки
        const id = video.id.replace('video-modal-', '');
        hlsPlayers[id] = hls;
    } else {
        console.warn('hls.js не подключен');
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

// Экспорт в глобальную область видимости для вызова из других бандлов
// (например, modal-stream.js), которые собираются отдельными entrypoints
// и не видят локальные символы модулей.
if (typeof window !== 'undefined') {
    window.startWebRTC = startWebRTC;
    window.stopWebRTC = stopWebRTC;
}