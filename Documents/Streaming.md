# Трансляция видеокамер: архитектура и реализация

## Обзор

Проект транслирует RTSP‑потоки IP‑камер через MediaMTX и отдаёт их в браузер:

-   WebRTC (WHEP) — приоритет для низкой задержки.
-   HLS — надёжныйfallback, особенно для мобильных.

Laravel управляет безопасностью и статистикой, рисует UI и подписывает ссылки.

## Компоненты

-   MediaMTX v1.14.x — конвертация RTSP→WebRTC/HLS, HTTP‑auth вебхуком, Control API.
-   Laravel 12 — генерация подписанных URL, вебхук авторизации, сбор статистики, админ‑UI.
-   Nginx — reverse proxy (в продакшене) для /hls и /whep на MediaMTX.
-   Vite + hls.js — фронтенд и HLS fallback.

## Поток данных (вкратце)

1. Камера (RTSP) → MediaMTX (paths.cam{id}.source).
2. Пользователь открывает страницу камер.
3. Для каждой камеры Laravel рендерит:
    - Статус online/offline (по Control API MediaMTX).
    - Подписанные URL: WHEP и HLS (с exp, token, uid).
4. Клиент пытается WHEP. При ошибке — HLS (нативный или через hls.js).
5. При запросе к MediaMTX он вызывает вебхук /api/mediamtx/auth:
    - Laravel валидирует подпись (HMAC) и срок действия exp.
    - При наличии uid проверяется блокировка и обновляется ViewSession.

## Безопасность

-   Подписанные ссылки: token = HMAC_SHA256(action|path|exp, STREAM_TOKEN_SECRET), передаются в query вместе с exp, uid.
-   Webhook (HTTP auth): MediaMTX шлёт POST → Laravel → 204/401/403.
-   CORS: MEDIAMTX_ALLOW_ORIGIN. В проде ограничьте вашим доменом.
-   Блокировка пользователей: users.stream_blocked (админ‑панель).

## Статистика и онлайн‑счётчик

-   Таблица view_sessions:
    -   Ключ на день: started_at = startOfDay() (по user/camera/protocol).
    -   При каждом запросе MediaMTX → обновляем last_seen_at, ip, ua.
-   «Сейчас смотрят»: COUNT(DISTINCT user_id) с last_seen_at >= now() - VIEWERS_ACTIVE_WINDOW сек.
-   «За день»: COUNT(\*) записей за текущие сутки.
-   «За всё время»: COUNT(\*) всех записей.
-   Окно активности настраивается: VIEWERS_ACTIVE_WINDOW (по умолчанию 45 сек, гвард 10–300).

## Ключевые файлы

-   app/Http/Controllers/StreamingController.php
    -   Получает статусы потоков (Control API) и собирает статистику для карточек.
-   app/Http/Controllers/MediaMtxAuthController.php
    -   Вебхук авторизации MediaMTX; валидация токена; учёт сессий; блокировки.
-   app/Console/Commands/GenerateMediaMtxConfig.php
    -   Генерирует mediamtx.yml из БД камер.
    -   Сохраняет глобальные секции и defaults в paths.all (sourceProtocol: tcp).
-   resources/views/streaming/partials/\*
    -   card.blade.php — карточка камеры, блокирует клик при offline.
    -   info-card.blade.php — выводит «Сейчас/За день/Всего».
    -   modal.blade.php — модальное окно плеера.
-   resources/js/webrtc-client.js
    -   WHEP с fallback на HLS; корректная остановка WebRTC/HLS при закрытии.
-   mediamtx.yml
    -   api/auth, CORS, paths (all + cam{id}). В paths.all принудительно TCP.

## Переменные окружения (.env)

-   STREAM_TOKEN_SECRET — секрет для HMAC (или APP_KEY).
-   MEDIAMTX_HOSTS — список Control API для статусов (через запятую), напр.: http://127.0.0.1:9997/v3/paths/list.
-   MEDIAMTX_HLS_BASE — базовый URL, что уйдёт в подписанные HLS ссылки (напр. https://site.ru/hls).
-   MEDIAMTX_WHEP_BASE — базовый URL для WHEP (напр. https://site.ru/whep).
-   MEDIAMTX_ALLOW_ORIGIN — допустимый Origin для HLS/WebRTC (в проде — ваш домен).
-   MEDIAMTX_WEBRTC_IPS — опционально, список публичных IP для ICE (CSV).
-   VIEWERS_ACTIVE_WINDOW — окно активности «Сейчас смотрят», сек (по умолчанию 45).

## Генерация конфига MediaMTX

-   Из БД: `php artisan mediamtx:generate-config`
-   Что делает:
    -   Не затирает глобальные секции (api, auth, CORS).
    -   В paths формирует итог из: paths.all (defaults) + cam{id}.source из БД.

## Типичные проблемы

-   unknown field … в YAML/JSON — параметр не поддерживается вашей версией MediaMTX. Уберите.
-   RTP packets lost — сеть/NAT/джиттер. Используем TCP (sourceProtocol: tcp) и/или настраиваем камеры (CBR, GOP ~1–2s).
-   «Сейчас смотрят» не гаснет сразу — зависит от VIEWERS_ACTIVE_WINDOW и корректного закрытия плеера (в проекте реализовано destroy для HLS и close для PeerConnection).
