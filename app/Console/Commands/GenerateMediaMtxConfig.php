<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Camera;
use Symfony\Component\Yaml\Yaml;

class GenerateMediaMtxConfig extends Command
{
    protected $signature = 'mediamtx:generate-config {--no-backup : Do not create .bak backup file}';
    protected $description = 'Генерирует конфиг mediamtx.yml из базы камер';

    public function handle()
    {
        $cameras = Camera::all();
        // 1) Прочитать существующий конфиг, чтобы сохранить api/auth и прочие настройки
        $configPath = base_path('mediamtx.yml');
        $config = [];
        if (file_exists($configPath)) {
            try {
                $config = Yaml::parseFile($configPath) ?? [];
            } catch (\Throwable $e) {
                $this->warn('Не удалось разобрать существующий mediamtx.yml, будет создан базовый: ' . $e->getMessage());
            }
        }

        // 2) Базовые значения по умолчанию (не затираем уже заданные)
        $config['logLevel'] = $config['logLevel'] ?? 'info';
        $config['hls'] = $config['hls'] ?? true;
        $config['webrtc'] = $config['webrtc'] ?? true;
        $config['rtsp'] = $config['rtsp'] ?? true;
        $config['api'] = $config['api'] ?? true;
        $config['apiAddress'] = $config['apiAddress'] ?? '0.0.0.0:9997';

        // Разрешённый Origin для HLS/WebRTC
        $allowOrigin = env('MEDIAMTX_ALLOW_ORIGIN', '*');
        if (!isset($config['hlsAllowOrigin'])) {
            $config['hlsAllowOrigin'] = $allowOrigin;
        }
        if (!isset($config['webrtcAllowOrigin'])) {
            $config['webrtcAllowOrigin'] = $allowOrigin;
        }

        // HTTP-аутентификация через наш вебхук
        $authUrl = env('MEDIAMTX_AUTH_URL');
        if (empty($authUrl)) {
            $appUrl = rtrim((string) (config('app.url') ?? 'http://localhost'), '/');
            $authUrl = $appUrl . '/api/mediamtx/auth';
        }
        if (!isset($config['authMethod'])) {
            $config['authMethod'] = 'http';
        }
        if (!isset($config['authHTTPAddress'])) {
            $config['authHTTPAddress'] = $authUrl;
        }
        if (!isset($config['authHTTPExclude'])) {
            $config['authHTTPExclude'] = [
                ['action' => 'api'],
                ['action' => 'metrics'],
                ['action' => 'pprof'],
            ];
        }

        // rtspAnyPortEnable отсутствует в вашей версии MediaMTX — не используем

        // Явные IP для WebRTC ICE (через env CSV, например "10.10.0.141,203.0.113.10")
        $webrtcIpsCsv = (string) env('MEDIAMTX_WEBRTC_IPS', '');
        if (!empty($webrtcIpsCsv)) {
            $ips = array_values(array_filter(array_map('trim', explode(',', $webrtcIpsCsv))));
            if (!empty($ips)) {
                $config['webrtcIPs'] = $ips;
            }
        }

        // Сохраняем auth и api, если уже есть, иначе не навязываем
        // $config['authMethod'] и $config['authInternalUsers'] трогаем только если заданы ранее

        // 3) Пересобрать раздел paths: сохраняем defaults в paths.all, камеры берём из БД
        $paths = [];

        // Сохраняем существующие defaults (paths.all), если есть
        $existingAll = $config['paths']['all'] ?? null;
        if (is_array($existingAll)) {
            $paths['all'] = $existingAll;
        } else {
            $paths['all'] = [
                // Глобальные дефолты для всех путей
                'sourceProtocol' => 'tcp',
            ];
        }

        foreach ($cameras as $camera) {
            // Пропустим камеры без RTSP-URL
            if (empty($camera->rtsp_url)) {
                continue;
            }
            $paths["cam{$camera->id}"] = [
                'source' => $camera->rtsp_url,
            ];
        }
        $config['paths'] = $paths;

        // 4) Сериализация YAML (с нормализацией)
        $yaml = Yaml::dump($config, 4, 2);
        // Нормализация проблемных случаев дампа YAML:
        //  - пустой список ips иногда сериализуется как {} (map), принудительно делаем [] (sequence)
        $yaml = preg_replace('/^(\s*)ips:\s*\{\s*\}\s*$/mi', '$1ips: []', $yaml);
        //  - api: 'yes'/'no' -> булевы значения
        $yaml = preg_replace('/^api:\s*["\']?yes["\']?\s*$/mi', 'api: true', $yaml);
        $yaml = preg_replace('/^api:\s*["\']?no["\']?\s*$/mi', 'api: false', $yaml);

        // 5) Если содержимое не изменилось — ничего не делаем
        if (file_exists($configPath)) {
            $existing = file_get_contents($configPath);
            if ($existing === $yaml) {
                $this->info('mediamtx.yml без изменений — запись и бэкап не требуются.');
                return Command::SUCCESS;
            }
        }

        // 6) Бэкап перед записью (если не отключён флагом)
        $noBackup = (bool) $this->option('no-backup');
        if (!$noBackup && file_exists($configPath)) {
            $backupPath = $configPath . '.' . date('Ymd_His') . '.bak';
            if (@copy($configPath, $backupPath)) {
                $this->info('Создан бэкап: ' . $backupPath);
                // Ротация бэкапов: оставить N последних
                $keep = (int) (env('MEDIAMTX_BACKUP_KEEP', 5));
                if ($keep > 0) {
                    $pattern = $configPath . '.*.bak';
                    $files = glob($pattern) ?: [];
                    // сортировка по времени изменения, новые первыми
                    usort($files, function ($a, $b) {
                        return filemtime($b) <=> filemtime($a);
                    });
                    $toDelete = array_slice($files, $keep);
                    foreach ($toDelete as $old) {
                        @unlink($old);
                    }
                    if (!empty($toDelete)) {
                        $this->info('Удалено старых бэкапов: ' . count($toDelete));
                    }
                }
            } else {
                $this->warn('Не удалось создать бэкап mediamtx.yml');
            }
        }

        // 7) Запись
        file_put_contents($configPath, $yaml);

        $this->info('mediamtx.yml успешно сгенерирован!');
    }
}
