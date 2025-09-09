<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Мой сайт')</title>
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/images/icons/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/icons/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/icons/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="/images/icons/favicon_io/site.webmanifest">
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

<body class="flex flex-col min-h-screen bg-white text-gray-900 dark:bg-[#161617] dark:text-gray-100">
    @include('components.header')

    <div class="mx-auto w-full max-w-[1440px] px-4 sm:px-6 lg:px-8 flex-grow">
        @yield('content')
    </div>

    @include('components.footer')
    @stack('scripts')
    @include('components.cookie-consent')

</body>

</html>
