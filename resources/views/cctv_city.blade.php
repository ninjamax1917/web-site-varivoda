@extends('layouts.app')

@section('title', 'Камеры города')

@section('content')
    <div class="text-center text-3xl font-bold lg py-30">
        <p>Камеры города</p>
    </div>

    <video id="video" controls autoplay class="rounded shadow-lg w-full max-w-2xl bg-black"></video>

    {{-- Видеоплеер --}}
    @vite('resources/js/player-hls.js')
@endsection
