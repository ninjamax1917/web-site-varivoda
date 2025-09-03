php artisan mediamtx:generate-config

Что настроить в .env (Laravel)

APP*URL=https://ваш-домен
STREAM_TOKEN_SECRET=случайный*длинный*секрет (не равен APP_KEY)
MEDIAMTX_HLS_BASE=полный внешний URL HLS, например https://ваш-домен/hls
MEDIAMTX_WHEP_BASE=полный внешний URL WHEP, например https://ваш-домен/whep
MEDIAMTX_HOSTS=адрес(а) Control API для Laravel (ИЗ контейнера ДО MediaMTX):
если MediaMTX на том же сервере, а Laravel в Docker: http://host.docker.internal:9997/v3/paths/list
если MediaMTX на отдельном хосте: http://IP*или_DNS:9997/v3/paths/list
Что настроить в mediamtx.yml (MediaMTX)

api: true
apiAddress: 127.0.0.1:9997 (не выставляйте в Интернет)
authMethod: http
authHTTPAddress:
если MediaMTX и Laravel на одном сервере: http://127.0.0.1/api/mediamtx/auth
если на разных: https://ваш-домен/api/mediamtx/auth (с валидным TLS)
authHTTPExclude: оставьте api/metrics/pprof (как сейчас)
hls: true, webrtc: true
hlsAllowOrigin: https://ваш-домен
webrtcAllowOrigin: https://ваш-домен
paths: генерируются нашей командой; перезапускайте MediaMTX после изменений
Реверс-прокси (Nginx/Traefik) — рекомендовано

Терминируйте TLS на 443 и проксируйте:
/hls/ → http://127.0.0.1:8888/
/whep/ → http://127.0.0.1:8889/
Отключите кэш для .m3u8; сегментам можно дать короткий Cache-Control.
Не проксируйте 9997 наружу; доступ только локально.
Сеть и безопасность

Откройте наружу только 80/443; закройте 8888/8889/9997 для внешней сети, если есть прокси.
Если Laravel в Docker на Linux — убедитесь, что есть extra_hosts: host.docker.internal:host-gateway (в docker-compose уже есть).
Синхронизируйте время (NTP/chrony) — токены короткоживущие.
Сервисы и перезапуски

Запустите MediaMTX как systemd-сервис (Restart=always).
После любого изменения mediamtx.yml перезапускайте MediaMTX.
В Laravel генератор уже обновляет конфиг при изменении камер; на проде добавьте шаг “restart mediamtx” в деплой/CI.
Использование в приложении

HLS: в плеер отдавайте $camera->signedHlsUrl() — токен и exp в ссылке.
WebRTC: фронт берёт data-whep с $camera->signedWhepUrl() — обмен по WHEP пройдёт с той же подписью.
TTL по умолчанию 300 cec; при необходимости передавайте другой TTL в методы signedHlsUrl()/signedWhepUrl().
Быстрая самопроверка

curl -I https://ваш-домен/hls/cam14/index.m3u8?exp=...&token=... → 200
POST WHEP с валидной ссылкой → 200/201 (а не 401/403)
В логах Laravel по POST /api/mediamtx/auth — 204; в логах MediaMTX — чтение path camXX.
