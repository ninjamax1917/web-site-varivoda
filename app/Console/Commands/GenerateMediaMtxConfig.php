<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Camera;
use Symfony\Component\Yaml\Yaml;

class GenerateMediaMtxConfig extends Command
{
    protected $signature = 'mediamtx:generate-config';
    protected $description = 'Генерирует конфиг mediamtx.yml из базы камер';

    public function handle()
    {
        $cameras = Camera::all();
        $config = [
            'logLevel' => 'info',
            'hls' => true,
            'webrtc' => true,
            'rtsp' => true,
            'paths' => [],
        ];

        foreach ($cameras as $camera) {
            $config['paths']["cam{$camera->id}"] = [
                'source' => $camera->rtsp_url,
            ];
        }

        $yaml = Yaml::dump($config, 4, 2);
        file_put_contents(base_path('mediamtx.yml'), $yaml);

        $this->info('mediamtx.yml успешно сгенерирован!');
    }
}
