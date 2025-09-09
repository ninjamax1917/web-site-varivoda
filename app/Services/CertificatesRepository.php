<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class CertificatesRepository
{
    /**
     * Собирает элементы сертификатов/лицензий из public/images/certificates.
     * Возвращает массив вида [key => ['image'?, 'pdf'?, 'title']]
     */
    public function list(): array
    {
        $dir = public_path('images/certificates');
        $files = File::exists($dir) ? File::files($dir) : [];
        $items = [];

        $normalizeKey = function (string $base) {
            // Убираем суффикс вида: "page 1", "page-1", "page_1" в конце имени
            $clean = preg_replace('/([_\-\s])*page([_\-\s])*\d+$/i', '', $base);
            // Нормализуем для ключа
            $norm = strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($clean)));
            $norm = trim($norm, '-');
            return [$norm, $clean];
        };

        foreach ($files as $f) {
            $ext = strtolower($f->getExtension());
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'pdf'])) {
                continue;
            }
            $raw = pathinfo($f->getFilename(), PATHINFO_FILENAME);
            [$key, $cleanTitle] = $normalizeKey($raw);
            if ($key === '' || $key === null) {
                $key = 'doc-' . substr(sha1($raw), 0, 8);
                if ($cleanTitle === '' || $cleanTitle === null) {
                    $cleanTitle = $raw;
                }
            }
            $url = asset('images/certificates/' . $f->getFilename());

            if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                $items[$key]['image'] = $url;
            } elseif ($ext === 'pdf') {
                $items[$key]['pdf'] = $url;
            }

            if (!isset($items[$key]['title'])) {
                $items[$key]['title'] = ucfirst(str_replace(['_', '-'], ' ', $cleanTitle));
            }
        }

        ksort($items);
        return $items;
    }
}
