@extends('layouts.app')

@section('title', 'Камеры города')

@section('content')
    <div class="text-center text-3xl font-bold lg py-30">
        <p>Камеры нашего города</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
        @foreach ($cameras as $camera)
            @include('streaming.partials.card', [
                'index' => $camera->id,
                'name' => $camera->name,
                'stream_path' => "cam{$camera->id}",
            ])
        @endforeach

    </div>



    @vite('resources/js/webrtc-client.js')
    @vite('resources/js/modal-stream.js')
@endsection
