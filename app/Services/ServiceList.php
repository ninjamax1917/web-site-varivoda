<?php

namespace App\Services;

class ServiceList
{
    public static function all()
    {
        return [
            ['name' => 'Электромонтажные работы', 'slug' => 'electricity', 'icon' => 'bolt'],
            ['name' => 'Видеонаблюдение', 'slug' => 'cctv', 'icon' => 'camera'],
            ['name' => 'Сети | Wifi | Связь', 'slug' => 'network', 'icon' => 'wifi'],
            ['name' => 'Противопожарная автоматика', 'slug' => 'fire-alarm', 'icon' => 'fire'],
            ['name' => 'Охранная сигнализация', 'slug' => 'security-alarm', 'icon' => 'shield'],
            ['name' => 'Проектирование', 'slug' => 'project', 'icon' => 'document'],
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
