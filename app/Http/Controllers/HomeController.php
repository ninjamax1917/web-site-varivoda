<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $services = [
            'Электромонтажные работы',
            'Видеонаблюдение',
            'Сети | Wifi | Связь',
            'Противопожарная автоматика',
            'Проектирование',
            'Охранная сигнализация',
        ];

        return view('home', compact('services'));
    }
}
