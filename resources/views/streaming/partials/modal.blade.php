<div id="modal-{{ $index }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 hidden">
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-2xl p-6 w-full max-w-2xl relative">
        <button id="close-modal-btn-{{ $index }}"
            class="absolute top-2 right-2 btn btn-sm btn-circle btn-ghost">✕</button>
        <h2 class="text-xl font-bold mb-4">Онлайн трансляция</h2>
        <video id="video-modal-{{ $index }}" controls autoplay
            class="rounded-lg w-full bg-black aspect-video"></video>
    </div>
</div>
