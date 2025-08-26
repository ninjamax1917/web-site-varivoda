sudo apt update
sudo apt install php8.3-xml~

composer install

**Зависимости npm**
vendor/bin/sail npm install

**Установка**

- curl -s "https://laravel.build/laravel-start-app?with=mysql" | bash

**Запуск**

- vendor/bin/sail up -d

- vendor/bin/sail npm run dev

**Установка плагинов**

- vendor/bin/sail composer require barryvdh/laravel-debugbar --dev
