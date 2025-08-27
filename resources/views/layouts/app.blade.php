<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Мой сайт')</title>
    <script>
        // Применяем тему до загрузки стилей, чтобы не было мерцания
        (function() {
            try {
                const stored = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const isDark = stored ? stored === 'dark' : prefersDark;
                document.documentElement.classList.toggle('dark', isDark);
            } catch (e) {
                /* no-op */
            }
        })();
    </script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="min-h-screen bg-white text-gray-900 dark:bg-gray-900 dark:text-gray-100">
    @include('components.header')

    <div class="container mx-auto">
        @yield('content')
    </div>

    @include('components.footer')


</body>

</html>
