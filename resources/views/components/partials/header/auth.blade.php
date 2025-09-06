@guest
    <div class="flex items-center space-x-4 ml-4 hide-928">
        <a class="link link-hover text-sm font-semibold" onclick="window.location='{{ route('login') }}'">Войти</a>
        <a class="link text-sm font-semibold border border-gray-800 dark:border-gray-300 rounded-lg px-4 py-2 text-gray-800 dark:text-gray-100 hover:bg-gray-800 dark:hover:bg-gray-100 hover:text-gray-100 dark:hover:text-gray-800 transition-all duration-200 no-underline"
            onclick="window.location='{{ route('register') }}'">
            Регистрация
        </a>
    </div>

@endguest

{{-- Аватарка аккаунта в header --}}
@auth
    <div class="dropdown dropdown-end lg:dropdown-center">
        <div tabindex="0" role="button" class="avatar cursor-pointer">
            <div class="ring-gray-500 w-9 rounded-full ring-1 overflow-hidden">
                @if (auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" />
                @else
                    <img src="{{ asset('images/default_avatar.gif') }}" alt="Avatar" />
                @endif
            </div>
        </div>
        <ul tabindex="0"
            class="dropdown-content menu bg-white dark:bg-[#232325] border border-gray-300 dark:border-gray-600 rounded-box z-1 w-52 p-2 shadow-sm mt-2">
            <li>
                <a href="{{ route('profile') }}" class="hover:bg-gray-300 dark:hover:bg-gray-700">Профиль</a>
            </li>
            <li><a href="{{ route('profile.settings') }}" class="hover:bg-gray-300 dark:hover:bg-gray-700">Настройки</a>
            </li>
            <hr class="my-1 border-gray-400 dark:border-gray-500">
            <li>
                <a href="#" class="hover:bg-gray-300 dark:hover:bg-gray-700"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Выйти
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
@endauth
