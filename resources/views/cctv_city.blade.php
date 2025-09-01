@extends('layouts.app')

@section('title', 'Камеры города')

@section('content')
    <div class="text-center text-3xl font-bold lg py-30">
        <p>Камеры города</p>
    </div>



    {{-- Видеоплеер --}}
    @vite('resources/js/player-hls.js')
@endsection
