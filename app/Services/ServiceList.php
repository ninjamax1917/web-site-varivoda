<?php

namespace App\Services;

class ServiceList
{
    public static function all()
    {
        return [
            ['name' => 'Электромонтажные работы', 'slug' => 'electricity'],
            ['name' => 'Видеонаблюдение', 'slug' => 'cctv'],
            ['name' => 'Сети | Wifi | Связь', 'slug' => 'network'],
            ['name' => 'Противопожарная автоматика', 'slug' => 'fire-alarm'],
            ['name' => 'Проектирование', 'slug' => 'project'],
            ['name' => 'Охранная сигнализация', 'slug' => 'security-alarm'],
        ];
    }

    public static function slugToView()
    {
        return [
            'cctv' => 'pages.cctv',
            'electricity' => 'pages.electricity',
            'fire-alarm' => 'pages.fire_alarm',
            'network' => 'pages.network',
            'project' => 'pages.project',
            'security-alarm' => 'pages.security_alarm',
        ];
    }
}
