@extends('layouts.app')

@section('title', 'Профиль пользователя')

@section('content')
    <section class="w-full py-12 md:py-16">
        <div class="mx-auto w-full max-w-[1440px] px-4 sm:px-6 lg:px-8">
            <h2
                class="max-w-4xl mx-auto text-left pl-4 sm:pl-6 lg:pl-8 text-3xl md:text-4xl font-bold mb-6
                   text-gray-900 dark:text-gray-100 border-l-4 border-[#51A3FF]">
                Личный кабинет
            </h2>

            <div
                class="mx-auto w-full max-w-4xl rounded-2xl ring-1 ring-gray-300 dark:ring-white/10 bg-white dark:bg-[#232325] shadow-sm p-6 sm:p-8">
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Левая колонка: аватар + данные -->
                    <div class="flex flex-col items-center md:w-2/5 w-full mb-6 md:mb-0">
                        @include('auth.components-profile.avatar')
                        <div class="mt-4 text-center">
                            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                {{ auth()->user()->name }}
                            </div>
                            <div class="text-gray-700 dark:text-gray-300">
                                Email: {{ auth()->user()->email }}
                            </div>
                            <div class="text-sm text-gray-500 mt-1">
                                Профиль создан: {{ auth()->user()->created_at->format('d.m.Y H:i') }}
                            </div>
                            <a href="{{ route('profile.settings') }}"
                                class="btn-glow inline-flex items-center justify-center mt-4 px-5 py-2 rounded-xl border border-[#51A3FF]/70 bg-white text-[#232325] dark:bg-[#232325] dark:text-gray-100 font-semibold shadow hover:bg-[#F0F7FF] dark:hover:bg-[#232325] hover:border-[#51A3FF] transition focus:outline-none focus:ring-2 focus:ring-[#51A3FF] focus:ring-offset-2 dark:focus:ring-offset-[#18181B]">
                                <span class="mr-2">Настройки профиля</span>
                                <span
                                    class="text-[#51A3FF] dark:text-[#DCEBFF] opacity-80 transition group-hover:opacity-100"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-user-round-pen-icon lucide-user-round-pen">
                                        <path d="M2 21a8 8 0 0 1 10.821-7.487" />
                                        <path
                                            d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                                        <circle cx="10" cy="8" r="5" />
                                    </svg></span>
                            </a>
                        </div>
                    </div>
                    <!-- Разделитель -->
                    <div class="hidden md:block border-l border-gray-200/70 dark:border-white/10 mx-8 self-stretch"></div>
                    <!-- Правая колонка: для других данных -->
                    <div class="flex flex-col justify-center md:w-3/5 w-full">
                        <div class="text-gray-500 text-center md:text-left">
                            <div role="alert" class="alert alert-info">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    class="h-6 w-6 shrink-0 stroke-current">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>У вас пока нет добавленных устройств.</span>
                            </div>
                            {{-- Админ-панель только для admin --}}
                            @include('auth.components-admin-panel.admin-panel')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
