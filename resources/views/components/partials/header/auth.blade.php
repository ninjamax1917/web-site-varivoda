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
            <div
                class="ring-gray-500 w-9 h-9 rounded-full ring-1 overflow-hidden bg-gray-200 dark:bg-gray-700 grid place-items-center">
                @if (auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar"
                        class="w-full h-full object-cover" />
                @else
                    @if (auth()->user()->role === 'admin')
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-5 h-5 text-gray-700 dark:text-gray-200 transform translate-y-[21px]">
                            <path
                                d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                            <path d="M6.376 18.91a6 6 0 0 1 11.249.003" />
                            <circle cx="12" cy="11" r="4" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-5 h-5 text-gray-700 dark:text-gray-200 transform translate-y-[21px]">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M8 14s1.5 2 4 2 4-2 4-2" />
                            <line x1="9" x2="9.01" y1="9" y2="9" />
                            <line x1="15" x2="15.01" y1="9" y2="9" />
                        </svg>
                    @endif
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
