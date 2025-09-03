# Продакшен: Ubuntu + Nginx + MediaMTX + Laravel

Ниже — проверенный сценарий развертывания сайта с трансляцией камер.

## 1) Сервер и зависимости

-   Ubuntu 22.04 LTS (или 24.04)
-   Установить: Nginx, PHP 8.3/8.4 (FPM), Redis (опционально), Node.js LTS (сборка), Certbot
-   Системный пользователь для проекта: например, `www-data` или `deploy`.

## 2) Код и окружение

-   Клонировать репозиторий в /var/www/site (или ваш путь).
-   Скопировать .env и задать ключи:
    -   APP_KEY (php artisan key:generate)
    -   STREAM_TOKEN_SECRET (или APP_KEY)
    -   MEDIAMTX_HLS_BASE=https://example.com/hls
    -   MEDIAMTX_WHEP_BASE=https://example.com/whep
    -   MEDIAMTX_ALLOW_ORIGIN=https://example.com
    -   MEDIAMTX_HOSTS=https://example.com/api/mediamtx/paths (см. ниже про прокси на 9997) или http://127.0.0.1:9997/v3/paths/list
    -   VIEWERS_ACTIVE_WINDOW=45
-   Composer install (prod): `composer install --no-dev --optimize-autoloader`
-   Сборка фронтенда: `npm ci && npm run build`
-   Миграции/сид: `php artisan migrate --force`

## 3) MediaMTX

-   Скачайте последнюю стабильную сборку для Linux amd64 и распакуйте в /opt/mediamtx
-   Конфиг `/opt/mediamtx/mediamtx.yml` (или храните в корне проекта, если так удобнее):
    -   api: true, apiAddress: 0.0.0.0:9997 (или 127.0.0.1:9997, если проксируете локально)
    -   authMethod: http; authHTTPAddress: https://example.com/api/mediamtx/auth
    -   hls: true; webrtc: true
    -   hlsAllowOrigin / webrtcAllowOrigin: https://example.com
    -   paths:
        -   all: sourceProtocol: tcp
        -   cam{id}: source: rtsp://...
-   Генерация из БД: `php artisan mediamtx:generate-config` (обновит `mediamtx.yml` в корне)
    -   Скопируйте/ссылкуйте его в /opt/mediamtx/ при необходимости
-   Запуск как systemd:

```
[Unit]
Description=MediaMTX Service
After=network.target

[Service]
ExecStart=/opt/mediamtx/mediamtx -config /opt/mediamtx/mediamtx.yml
Restart=always
User=www-data
WorkingDirectory=/opt/mediamtx

[Install]
WantedBy=multi-user.target
```

-   `sudo systemctl enable --now mediamtx`

## 4) Nginx (HTTPS + прокси)

-   Cертификаты: `sudo certbot --nginx -d example.com`
-   Серверный блок (упрощённо):

```
server {
    listen 80;
    server_name example.com;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name example.com;

    # ssl ... (certbot добавит)

    root /var/www/site/public;
    index index.php;

    # Laravel
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock; # версия PHP
    }

    # Прокси на MediaMTX HLS
    location /hls/ {
        proxy_pass http://127.0.0.1:8888/; # MediaMTX HLS
        proxy_set_header Host $host;
        proxy_http_version 1.1;
    }

    # Прокси на MediaMTX WHEP (WebRTC)
    location /whep/ {
        proxy_pass http://127.0.0.1:8889/; # MediaMTX WHEP
        proxy_set_header Host $host;
        proxy_http_version 1.1;
    }

    # Прокси на MediaMTX Control API (для статусов)
    location /api/mediamtx/paths {
        proxy_pass http://127.0.0.1:9997/v3/paths/list;
    }
}
```

-   Проверьте, что в .env:
    -   MEDIAMTX_HLS_BASE=https://example.com/hls
    -   MEDIAMTX_WHEP_BASE=https://example.com/whep
    -   MEDIAMTX_HOSTS=https://example.com/api/mediamtx/paths (или локальный 127.0.0.1)

## 5) PHP-FPM/Laravel как сервис

-   Опционально — supervisor/systemd для queue/workers, если требуется.
-   Права на storage/bootstrap/cache: `chown -R www-data:www-data storage bootstrap/cache`

## 6) База данных

-   Настроить .env DB\_\*.
-   `php artisan migrate --force`.

## 7) Проверка

-   Откройте https://example.com/cctv-city (или ваш маршрут). Карточки камер показывают онлайн.
-   Клик по онлайн-камере — откроется модалка; WebRTC стартует, при сбое — HLS.
-   В логах MediaMTX — чтение из path cam{id}. В логах Laravel — запросы вебхука 204.

## 8) Обновления и ротации

-   При добавлении/удалении камеры:
    -   Обновите БД → `php artisan mediamtx:generate-config` → перезагрузите MediaMTX (`systemctl restart mediamtx`).
-   Безопасность:
    -   Ограничьте MEDIAMTX_ALLOW_ORIGIN вашим доменом.
    -   Доступ к :8888/:8889/:9997 снаружи не открывайте, только через Nginx.
-   Мониторинг:
    -   Nginx access/error, MediaMTX логи, Laravel логи.

## 9) Траблшутинг

-   401/403 при попытке воспроизведения — проверьте STREAM_TOKEN_SECRET и URL вебхука в mediamtx.yml.
-   unknown field в медиа-конфиге — уберите неподдерживаемый ключ (версии MediaMTX отличаются).
-   Потери RTP — используйте sourceProtocol: tcp (уже по умолчанию), настройте CBR и GOP на камерах.
