@extends('layouts.app')

@section('title', 'Камеры города')

@section('content')
    <div class="text-center text-2xl font-semibold text-gray-900 dark:text-gray-200 lg py-15">
        <p>Камеры нашего города</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
        @foreach ($cameras as $camera)
            @include('streaming.partials.card', [
                'index' => $camera->id,
                'name' => $camera->name,
                'stream_path' => "cam{$camera->id}",
                'whep_url' => $camera->signedWhepUrl(300, auth()->id()),
                'hls_url' => $camera->signedHlsUrl(300, auth()->id()),
                'is_online' => (bool) ($statuses["cam{$camera->id}"] ?? false),
            ])
        @endforeach
    </div>
    @vite('resources/js/webrtc-client.js')
    @vite('resources/js/modal-stream.js')
    @vite('resources/js/view-stats.js')
    <script src="https://cdn.jsdelivr.net/npm/hls.js@^1.5.0/dist/hls.min.js"></script>
@endsection
