@extends('layouts.app')

@section('content')
    <div>
        <section class="py-16 px-4 sm:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Добро пожаловать в нашу компанию!
                </h1>
                <p class="text-lg sm:text-xl text-gray-700 dark:text-gray-300 mb-6">
                    Мы — команда профессионалов с 10-летним опытом в сфере:
                </p>
                <ul class="text-left inline-block mb-6 text-gray-700 dark:text-gray-300 text-lg space-y-2">
                    <li class="flex items-center"><span class="text-blue-500 mr-2">•</span>Электромонтажные работы до и свыше
                        0.4кВ</li>
                    <li class="flex items-center"><span class="text-blue-500 mr-2">•</span>Локальные вычислительные сети и СКС
                    </li>
                    <li class="flex items-center"><span class="text-blue-500 mr-2">•</span>WIFI и радиооборудование</li>
                    <li class="flex items-center"><span class="text-blue-500 mr-2">•</span>Противопожарная автоматика</li>
                    <li class="flex items-center"><span class="text-blue-500 mr-2">•</span>Видеонаблюдение</li>
                    <li class="flex items-center"><span class="text-blue-500 mr-2">•</span>Охранная сигнализация</li>
                </ul>
                <p class="text-base text-gray-600 dark:text-gray-400">
                    Гарантируем качество, надежность и индивидуальный подход к каждому клиенту.
                </p>
            </div>
        </section>
    </div>
@endsection
