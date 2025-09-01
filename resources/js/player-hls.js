import Hls from 'hls.js';

document.addEventListener('DOMContentLoaded', function() {
    var video = document.getElementById('video'); // было 'city-cam', стало 'video'
    var videoSrc = 'http://localhost:8888/mycam/index.m3u8'; // замените на свой IP, если не localhost
    if (Hls.isSupported()) {
        var hls = new Hls();
        hls.loadSource(videoSrc);
        hls.attachMedia(video);
    } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
        video.src = videoSrc;
    }
});