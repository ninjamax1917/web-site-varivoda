<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VoltageDropRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $voltageKeys = array_keys(config('cable.voltage'));
        $methodKeys = array_keys(config('cable.method'));
        $materialKeys = array_keys(config('cable.materials'));
        $sectionKeys = array_keys(config('cable.sections'));
        $cableKeys = array_map('strval', array_keys(config('cable.number_of_cables')));

        return [
            'voltage' => ['required', Rule::in($voltageKeys)],
            'method' => ['required', Rule::in($methodKeys)],
            'material' => ['required', Rule::in($materialKeys)],
            'section' => ['required', Rule::in($sectionKeys)],
            'temperature' => ['required', 'numeric', 'between:-50,100'],
            'length' => ['required', 'numeric', 'between:0.01,10000'],
            'voltageValue' => ['required', 'numeric', 'between:0.01,10000'],
            'number_of_cables' => ['required', Rule::in($cableKeys)],
            'current' => ['nullable', 'required_if:method,current', 'numeric', 'between:0.01,10000'],
            'power' => ['nullable', 'required_if:method,power', 'numeric', 'between:0.01,1000000'],
            'cosifi' => [
                'nullable',
                'required_if:method,power',
                'exclude_if:voltage,VOLTAGE_DC',
                'numeric',
                'between:0.1,1'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Поле :attribute обязательно для заполнения.',
            'numeric' => 'Поле :attribute должно быть числом.',
            'between' => 'Поле :attribute должно быть в диапазоне :min–:max.',
            'in' => 'Выбранное значение для :attribute недопустимо.',
            'required_if' => 'Поле :attribute обязательно, когда выбран метод ":value".',
            'exclude_if' => 'Поле :attribute не должно быть заполнено для выбранного типа тока.',

            'current.between' => 'Сила тока должна быть в диапазоне :min–:max А.',
            'power.between' => 'Мощность должна быть в диапазоне :min–:max Вт.',
            'cosifi.between' => 'Коэффициент мощности должен быть в диапазоне :min–:max.',
            'length.between' => 'Длина кабеля должна быть в диапазоне :min–:max м.',
            'voltageValue.between' => 'Напряжение сети должно быть в диапазоне :min–:max В.',
            'temperature.between' => 'Температура должна быть в диапазоне :min–:max °C.',

            // Кастом для читабельности без англ. значений
            'current.required_if' => 'Поле "Сила тока" не может быть пустым.',
            'power.required_if' => 'Поле "Мощность" не может быть пустым.',
            'cosifi.required_if' => 'Поле "Коэффициент мощности (cos φ)" не может быть пустым.',
        ];
    }

    public function attributes(): array
    {
        return [
            'voltage' => 'тип тока',
            'method' => 'метод расчета',
            'material' => 'материал',
            'section' => 'площадь сечения',
            'temperature' => 'температура кабеля',
            'length' => 'длина кабеля',
            'voltageValue' => 'напряжение сети',
            'number_of_cables' => 'количество кабелей',
            'current' => 'сила тока',
            'power' => 'мощность',
            'cosifi' => 'коэффициент мощности (cos φ)',
        ];
    }
}
