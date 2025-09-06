@extends('layouts.app')

@section('content')
    <div class="py-20 px-1 sm:px-4 md:px-8">
        <div class="max-w-xs sm:max-w-md md:max-w-2xl lg:max-w-4xl xl:max-w-6xl mx-auto w-full">
            <section>
                <x-partials-home.section-1 />
            </section>
            <section class="py-10">
                <!-- Ваш контент -->
            </section>
        </div>
    </div>
@endsection
