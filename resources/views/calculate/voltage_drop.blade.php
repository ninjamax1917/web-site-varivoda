@extends('layouts.app')

@section('content')
<section class="w-full py-12 md:py-16">
    <div class="mx-auto w-full max-w-[1440px] px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-4xl font-bold mb-6 text-gray-900 dark:text-gray-100 border-l-4 border-[#51A3FF] pl-3">Калькулятор падения напряжения</h1>

        <div class="rounded-2xl bg-gradient-to-b from-[#F8FBFF] to-white dark:from-[#1A1A1D] dark:to-[#141416] ring-1 ring-gray-200/70 dark:ring-white/10 p-4 sm:p-6 md:p-8">
            <form id="calcForm" method="post" action="{{ route('calc.calculate') }}" onsubmit="submitForm(event)" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 items-start">
                    <div>
                        <label for="voltage" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Тип тока</label>
                        <div class="relative select-with-arrow">
                            <select name="voltage" id="voltage" onchange="toggleFields(); setDefaultVoltage(true);" class="mt-1 w-full rounded-xl border appearance-none @error('voltage') border-red-500 @else border-slate-300 dark:border-white/10 @enderror bg-white dark:bg-[#232325] text-gray-900 dark:text-gray-100 px-3 pr-10 py-2 focus:ring-2 focus:ring-[#51A3FF] focus:outline-none">
                                @foreach($voltage as $key => $label)
                                    <option value="{{ $key }}" @selected(old('voltage')===$key)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <span class="select-arrow pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 transition-transform duration-500 ease-out">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                            </span>
                        </div>
                        @error('voltage')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="voltageValue" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Напряжение сети, В</label>
                        <input type="number" step="any" name="voltageValue" id="voltageValue" value="{{ old('voltageValue','220') }}" class="mt-1 w-full rounded-xl border @error('voltageValue') border-red-500 @else border-slate-300 dark:border-white/10 @enderror bg-white dark:bg-[#232325] text-gray-900 dark:text-gray-100 px-3 py-2 focus:ring-2 focus:ring-[#51A3FF] focus:outline-none" placeholder="Например, 220">
                        @error('voltageValue')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="method" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Метод расчета</label>
                        <div class="relative select-with-arrow">
                            <select name="method" id="method" onchange="toggleFields()" class="mt-1 w-full rounded-xl border appearance-none @error('method') border-red-500 @else border-slate-300 dark:border-white/10 @enderror bg-white dark:bg-[#232325] text-gray-900 dark:text-gray-100 px-3 pr-10 py-2 focus:ring-2 focus:ring-[#51A3FF] focus:outline-none">
                                @foreach($method as $key => $label)
                                    <option value="{{ $key }}" @selected(old('method')===$key)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <span class="select-arrow pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 transition-transform duration-500 ease-out">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                            </span>
                        </div>
                        @error('method')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="material" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Материал</label>
                        <div class="relative select-with-arrow">
                            <select name="material" id="material" class="mt-1 w-full rounded-xl border appearance-none @error('material') border-red-500 @else border-slate-300 dark:border-white/10 @enderror bg-white dark:bg-[#232325] text-gray-900 dark:text-gray-100 px-3 pr-10 py-2 focus:ring-2 focus:ring-[#51A3FF] focus:outline-none">
                                @foreach($materials as $name => $val)
                                    <option value="{{ $name }}" @selected(old('material')===$name)>{{ $name }}</option>
                                @endforeach
                            </select>
                            <span class="select-arrow pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 transition-transform duration-500 ease-out">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                            </span>
                        </div>
                        @error('material')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="length" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Длина кабеля (м)</label>
                        <input type="number" step="any" name="length" id="length" value="{{ old('length') }}" class="mt-1 w-full rounded-xl border @error('length') border-red-500 @else border-slate-300 dark:border-white/10 @enderror bg-white dark:bg-[#232325] text-gray-900 dark:text-gray-100 px-3 py-2 focus:ring-2 focus:ring-[#51A3FF] focus:outline-none" placeholder="Например, 50">
                        @error('length')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="section" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Площадь сечения</label>
                        <div class="relative select-with-arrow">
                            <select name="section" id="section" class="mt-1 w-full rounded-xl border appearance-none @error('section') border-red-500 @else border-slate-300 dark:border-white/10 @enderror bg-white dark:bg-[#232325] text-gray-900 dark:text-gray-100 px-3 pr-10 py-2 focus:ring-2 focus:ring-[#51A3FF] focus:outline-none">
                                @foreach($sections as $name => $val)
                                    <option value="{{ $name }}" @selected(old('section')===$name)>{{ $name }}</option>
                                @endforeach
                            </select>
                            <span class="select-arrow pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 transition-transform duration-500 ease-out">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                            </span>
                        </div>
                        @error('section')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 items-start">
                        <div class="space-y-4">
                            <div>
                                <label for="number_of_cables" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Количество кабелей</label>
                                <div class="relative select-with-arrow">
                                    <select name="number_of_cables" id="number_of_cables" class="mt-1 w-full rounded-xl border appearance-none @error('number_of_cables') border-red-500 @else border-slate-300 dark:border-white/10 @enderror bg-white dark:bg-[#232325] text-gray-900 dark:text-gray-100 px-3 pr-10 py-2 focus:ring-2 focus:ring-[#51A3FF] focus:outline-none">
                                        @foreach($number_of_cables as $num => $val)
                                            <option value="{{ (string)$num }}" @selected(old('number_of_cables','1')===(string)$num)>{{ (string)$num }}</option>
                                        @endforeach
                                    </select>
                                    <span class="select-arrow pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 transition-transform duration-500 ease-out">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                                    </span>
                                </div>
                                @error('number_of_cables')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="temperature" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Температура кабеля (°C)</label>
                                <input type="number" step="any" name="temperature" id="temperature" value="{{ old('temperature','20') }}" class="mt-1 w-full rounded-xl border @error('temperature') border-red-500 @else border-slate-300 dark:border-white/10 @enderror bg-white dark:bg-[#232325] text-gray-900 dark:text-gray-100 px-3 py-2 focus:ring-2 focus:ring-[#51A3FF] focus:outline-none" placeholder="Например, 20">
                                @error('temperature')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div id="method-fields" class="relative">
                            <div id="current-fields" style="display: {{ old('method','current')==='current' ? 'block' : 'none' }}">
                                <label for="current" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Сила тока (A)</label>
                                <input type="number" step="any" name="current" id="current" value="{{ old('current') }}" class="mt-1 w-full rounded-xl border @error('current') border-red-500 @else border-slate-300 dark:border-white/10 @enderror bg-white dark:bg-[#232325] text-gray-900 dark:text-gray-100 px-3 py-2 focus:ring-2 focus:ring-[#51A3FF] focus:outline-none" placeholder="Например, 5">
                                @error('current')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="power-fields" style="display: {{ old('method','current')==='power' ? 'block' : 'none' }}">
                                <label for="power" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Мощность (Вт)</label>
                                <input type="number" step="any" name="power" id="power" value="{{ old('power') }}" class="mt-1 w-full rounded-xl border @error('power') border-red-500 @else border-slate-300 dark:border-white/10 @enderror bg-white dark:bg-[#232325] text-gray-900 dark:text-gray-100 px-3 py-2 focus:ring-2 focus:ring-[#51A3FF] focus:outline-none" placeholder="Например, 1000">
                                @error('power')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                                <div class="mt-2">
                                    <label for="cosifi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Коэффициент мощности (cos φ)</label>
                                    <input type="number" step="any" name="cosifi" id="cosifi" min="0.1" max="1" value="{{ old('cosifi') }}" class="mt-1 w-full rounded-xl border @error('cosifi') border-red-500 @else border-slate-300 dark:border-white/10 @enderror bg-white dark:bg-[#232325] text-gray-900 dark:text-gray-100 px-3 py-2 focus:ring-2 focus:ring-[#51A3FF] focus:outline-none" placeholder="Например, 0.9">
                                    @error('cosifi')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#51A3FF] hover:bg-[#3A8DE0] text-white px-5 py-3 font-semibold shadow-sm focus:outline-none focus:ring-2 focus:ring-[#51A3FF] focus:ring-offset-2 dark:focus:ring-offset-[#18181B]">
                        Рассчитать
                    </button>
                </div>

                <div id="result-block" class="mt-4">
                    @if (session('result'))
                        @php($result = session('result'))
                        @php($isBad = ($result['voltageDrop_percent'] ?? 0) >= 10)
                        <div class="result mt-3 rounded-xl border p-4 {{ $isBad ? 'border-red-400 bg-red-50 text-red-700 dark:border-red-500/60 dark:bg-red-900/20 dark:text-red-300' : 'border-gray-200 dark:border-white/10 bg-white/70 dark:bg-[#232325]/50 text-gray-900 dark:text-gray-100' }}">
                            <strong class="block mb-2">Результаты расчета</strong>
                            <div>Падение напряжения (ΔU): <span class="font-semibold">{{ $result['voltageDrop_number'] }}</span> В (<span class="font-semibold">{{ $result['voltageDrop_percent'] }}</span> %)</div>
                            @if (old('method')==='power')
                                <div>Сила тока (I): <span class="font-semibold">{{ $result['current'] }}</span> А</div>
                            @elseif (old('method')==='current')
                                <div>Мощность (P): <span class="font-semibold">{{ $result['power'] }}</span> кВт</div>
                            @endif
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</section>
@vite('resources/js/voltage_drop.js')
@endsection