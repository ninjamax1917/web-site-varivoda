@guest
<div class="flex items-center space-x-4 ml-4 hide-928">
    <a class="link link-hover text-sm font-semibold" onclick="window.location='{{ route('login') }}'">Войти</a>
    <a
        class="link text-sm font-semibold border border-gray-800 dark:border-gray-300 rounded-lg px-4 py-2 text-gray-800 dark:text-gray-100 hover:bg-gray-800 dark:hover:bg-gray-100 hover:text-gray-100 dark:hover:text-gray-800 transition-all duration-200 no-underline"
        onclick="window.location='{{ route('register') }}'">
        Регистрация
    </a>
</div>

@endguest

@auth
<div class="avatar">
    <div class="ring-primary ring-offset-base-900 w-9 rounded-full ring-2 ring-offset-2">
        <img src="https://img.daisyui.com/images/profile/demo/spiderperson@192.webp" />
    </div>
</div>
@endauth


