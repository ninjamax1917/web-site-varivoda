@extends('layouts.app')

@section('title', 'Вход на сайт')

@section('content')
    <section class="w-full py-12 md:py-16">
        <div class="mx-auto w-full max-w-[1440px] px-4 sm:px-6 lg:px-8">
            <h2
                class="text-3xl md:text-4xl font-bold mb-6 text-gray-900 dark:text-gray-100 border-l-4 border-[#51A3FF] pl-3">
                Вход
            </h2>

            <div
                class="mx-auto w-full max-w-md rounded-2xl ring-1 ring-gray-300 dark:ring-white/10 bg-white dark:bg-[#232325] shadow-sm p-6 sm:p-8">
                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label for="login" class="block text-sm font-medium text-gray-900 dark:text-gray-200 mb-1">Email
                            или
                            имя пользователя</label>
                        <input type="text" id="login" name="login" value="{{ old('login') }}" required
                            @class([
                                'w-full rounded-xl border bg-white dark:bg-[#1A1A1D] px-4 py-3 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#51A3FF] focus:border-[#51A3FF] transition',
                                'border-red-500 dark:border-red-500' => $errors->has('login'),
                                'border-gray-300 dark:border-white/10' => !$errors->has('login'),
                            ]) />
                        @error('login')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="password"
                            class="block text-sm font-medium text-gray-900 dark:text-gray-200 mb-1">Пароль</label>
                        <input type="password" id="password" name="password" required @class([
                            'w-full rounded-xl border bg-white dark:bg-[#1A1A1D] px-4 py-3 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#51A3FF] focus:border-[#51A3FF] transition',
                            'border-red-500 dark:border-red-500' => $errors->has('password'),
                            'border-gray-300 dark:border-white/10' => !$errors->has('password'),
                        ]) />
                        @error('password')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit"
                        class="btn-glow w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border border-[#51A3FF] bg-white text-gray-900 dark:bg-[#232325] dark:text-gray-100 hover:bg-[#F0F7FF] dark:hover:bg-[#232325] hover:border-[#51A3FF] shadow-sm hover:shadow focus:outline-none focus:ring-2 focus:ring-[#51A3FF] focus:ring-offset-2 dark:focus:ring-offset-[#18181B] transition font-semibold">
                        Войти
                    </button>
                </form>
                <div class="mt-6 text-center">
                    <span class="text-gray-600 dark:text-gray-300 text-sm">Нет аккаунта?</span>
                    <a href="{{ route('register') }}"
                        class="text-[#1E40AF] hover:text-[#153189] dark:text-[#DCEBFF] dark:hover:text-white font-medium ml-1">
                        Зарегистрироваться
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
