@extends('layouts.app')

@section('content')
    <section class="pt-20">
        <div class="flex flex-wrap justify-center gap-16">
            @forelse($cards as $card)
                <x-service-card :title="$card->title" :images="$card->images" />
            @empty
                <p class="text-center text-sm text-gray-500">Пока нет карточек для этой страницы.</p>
            @endforelse
        </div>
    </section>
@endsection
