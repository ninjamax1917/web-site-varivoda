@extends('layouts.app')

@section('title', 'Настройка профиля')

@section('content')
    <section class="w-full py-12 md:py-16">
        <div class="mx-auto w-full max-w-[1440px] px-4 sm:px-6 lg:px-8">
            <h2
                class="text-3xl md:text-4xl font-bold mb-6 text-gray-900 dark:text-gray-100 border-l-4 border-[#51A3FF] pl-3">
                Редактировать профиль
            </h2>

            <div
                class="mx-auto w-full max-w-5xl rounded-2xl ring-1 ring-gray-300 dark:ring-white/10 bg-white dark:bg-[#232325] shadow-sm p-6 sm:p-8">
                <div class="flex flex-col md:flex-row gap-10">
                    <!-- Левая колонка: аватар -->
                    <div class="flex flex-col items-center md:w-1/3 w-full mb-6 md:mb-0">
                        @include('auth.components-setting.avatar')
                        @if ($errors->has('avatar'))
                            <div class="text-red-500 text-sm mt-2">
                                {{ $errors->first('avatar') }}
                            </div>
                        @endif
                        <a href="{{ route('profile') }}"
       class="btn-glow inline-flex items-center justify-center mt-10 px-5 py-2 rounded-xl border border-[#51A3FF]/70 bg-white text-[#232325] dark:bg-[#232325] dark:text-gray-100 font-semibold shadow hover:bg-[#F0F7FF] dark:hover:bg-[#232325] hover:border-[#51A3FF] transition focus:outline-none focus:ring-2 focus:ring-[#51A3FF] focus:ring-offset-2 dark:focus:ring-offset-[#18181B]">
        <span class="mr-2">Вернуться в профиль</span>
        <span class="text-[#51A3FF] dark:text-[#DCEBFF] opacity-80 transition group-hover:opacity-100">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="lucide lucide-user-round-icon lucide-user-round">
            <circle cx="12" cy="8" r="5"/>
            <path d="M20 21a8 8 0 0 0-16 0"/>
        </svg>
        </span>
    </a>
                    </div>
                    
                    <div class="hidden md:block border-l border-gray-200/70 dark:border-white/10 mx-8"></div>
                    <!-- Правая колонка: форма и кнопка выхода -->
                    <div class="flex flex-col gap-6 md:w-2/3 w-full">
                        @include('auth.components-setting.form')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
