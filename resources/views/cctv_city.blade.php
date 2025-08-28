@extends('layouts.app')

@section('content')
    <div class="text-center text-3xl font-bold lg py-30">
        <p>Камеры города</p>
    </div>

    @auth
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                Выйти
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            Войти
        </a>
    @endauth
@endsection
