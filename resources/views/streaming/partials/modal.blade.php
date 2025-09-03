<div id="modal-{{ $index }}" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm">
    <div class="min-h-full grid place-items-center p-4">
        <div
            class="relative w-full max-w-3xl rounded-2xl border border-black/10 dark:border-white/10 bg-white/90 dark:bg-gray-900/90 shadow-2xl">
            <div class="flex items-center justify-between px-4 py-3 border-b border-black/10 dark:border-white/10">
                <div class="flex items-center gap-3">
                    @if (!empty($is_online))
                        <span
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                            <span class="inline-block w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            Онлайн
                        </span>
                    @else
                        <span
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                            <span class="inline-block w-2 h-2 rounded-full bg-red-500"></span>
                            Оффлайн
                        </span>
                    @endif
                    <h2 class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $name }}</h2>
                </div>
                <button id="close-modal-btn-{{ $index }}" aria-label="Закрыть"
                    class="btn btn-sm btn-circle btn-ghost">✕</button>
            </div>
            <div class="relative">
                <video id="video-modal-{{ $index }}" controls autoplay playsinline muted
                    class="w-full aspect-video rounded-b-2xl bg-black"></video>
            </div>
        </div>
    </div>
</div>
